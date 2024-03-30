$(document).ready(function(){
    loadMobileMenu();
    loadRegularExpressions();
    pageRelatedFeatures();
});
function loadMobileMenu(){
    $("#menu-button").click(function(){
        $("#responsive-menu-wrapper")
        .toggle(300);
    });
    if($("#user-menu-wrapper").length){
        $("#responsive-menu-wrapper").css("top", "120px");
    }
}
function ajaxData(url, method, data = {}){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: method,
            dataType: "json",
            data: data,
            success: function(data){
                resolve(data);
            },
            error: function(xhr){
                reject("Error communicating with " + url + ", status: " + xhr.status);
                console.log(xhr);
            }
        });
    });
}

function loadRegularExpressions(){
    window.forms = {};
    window.forms.name = {
        "regex" : /^\p{Uppercase_Letter}\p{Letter}{1,14}(\s\p{Uppercase_Letter}\p{Letter}{1,14}){0,3}$/u,
        "length": 30,
        "message": "All words must begin with a capital letter."
    };
    window.forms.fullName = {
        "regex" : /^\p{Uppercase_Letter}\p{Letter}{1,14}(\s\p{Uppercase_Letter}\p{Letter}{1,14}){1,3}$/u,
        "length": 30,
        "message": "All words must begin with a capital letter."
    };
    window.forms.title = {
        "regex" : /^.{10,70}$/,
        "length": 70,
        "message": "Title must have at least 10 characters."
    };
    window.forms.description = {
        "regex" : /^.{20,1000}$/s,
        "length": 1000,
        "message": "Description must have at least 20 characters."
    };
    window.forms.price = {
        "regex" : /^\d+(\.\d+)?$/,
        "length": 10,
        "message": "Use digits, you can separate with dot."
    };
    window.forms.email = {
        "regex" : /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i,
        "length": 50,
        "message": "Use only letters, numbers and symbols @.-_"
    };
    window.forms.city = {
        "regex" : /^[\p{L}\w\.\-\s]{2,50}$/u,
        "length": 50,
        "message": "Enter your city/area correctly."
    };
    window.forms.country = {
        "regex" : /^[\p{L}\w\.\-\s]{2,50}$/u,
        "length": 50,
        "message": "Enter your country correctly."
    };
    window.forms.subject = {
        "regex": /^[\p{L}\w\.,\?!\/\-]{2,30}$/u,
        "length": 30,
        "message": "You can use letters, numbers and symbols .,-/?!"
    };
    window.forms.message = {
        "regex": /.{20,}/,
        "length": 200,
        "message": "Message must be at least 20 characters long."
    };
    window.forms.password = {
        "regex": /^(?=.*\p{Uppercase_Letter})(?=.*\p{Lowercase_Letter})(?=.*\d)(?=.{6,50})/u,
        "length": 50,
        "message": "Password must be between 6 and 50 characters and contain 1 uppercase, 1 lowercase letter and 1 number."
    };
    window.forms.username = {
        "regex": /^\w{3,30}$/,
        "length": 30,
        "message": "Username should be at least 3 characters long and contain only letters, numbers and symbol _"
    };
}
function validateString(string, validation){
    if(string == ""){
        return "empty";
    }
    if(string.length > validation.length){
        return "long";
    }
    if(!validation.regex.test(string)){
        return "incorrect";
    }
    return "valid";
}
function validateElement(element, validation){
    let fieldName = $(element).data("title");
    let fieldValidation = validateString($(element).val(), validation);
    if(fieldValidation == "empty"){
        formError(element, `Please input ${fieldName.toLowerCase()}.`);
    }
    if(fieldValidation == "long"){
        formError(element, `${fieldName} is too long. Maximum characters: ${validation.length}.`);
    }
    else if(fieldValidation == "incorrect"){
        formError(element, `${fieldName} is invalid. ${validation.message}`);
    }
}
function formError(element, message){
    $(`<p class="form-error small text-danger">${message}</p>`).insertAfter($(element));
    window.forms.error = true;
}
function resetFormMessages(){
    $(".form-error").remove();
    $(".form-success").remove();
}


function pageRelatedFeatures(){
    if($("main#buy").length){
        loadBuyPage();
    }
    if($("main#products").length){
        loadProductsPage();
    }
    if($("main#sell").length){
        loadSellPage();
    }
    if($("main#product-view").length){
        loadProductViewPage();
    }
    if($("main#c-h-a-t").length){
        loadChatPage();
    }
    if($("main#admin").length){
        loadAdminPage();
    }
    if($("main#contact").length){
        loadContactPage();
    }
    if($("main#register").length){
        loadRegisterPage();
    }
    if($("main#login").length){
        loadLoginPage();
    }
}
async function loadBuyPage(){
    try {
        let categories = await ajaxData("models/products/get-categories.php", "get", {"ajax":"true"});
        let html = "";
        for(let cat of categories){
            html += `<div class="col-12 col-sm-6 col-md-4 col-lg-3 p-3">
            <a class="category text-dark" href="index.php?page=products&category=${cat.category_id}">
                <div class="card category border rounded shadow">
                    <img class="card-img" src="assets/images/${cat.image_thumbnail_filename}" alt="${cat.image_title}" />
                    <div class="card-body py-4 px-1">
                        <h3 class="card-title h5 font-weight-light">${cat.category_name}</h3>
                    </div>
                </div>
            </a>
        </div>`;
        }
        $("#categories").html(html);

    }
    catch(ex){

    }
}
async function loadProductsPage(){
    
    let catId = category_info.category_id;
    try {
        let response = await ajaxData("models/products/get-products.php", "get", {"cat_id":catId, "count_products":"true"});
        filterChangeDetector();
        window.productCount = response.product_count;
        showPaginationLinks(8, 1);
        showProducts(response.products);
        $("#products-filters input, #search-products, #sort-products, #paginate-products").change(function(){
            refreshProducts();
        });
        $("#clear-filters").click(clearFilters);
        
    }
    catch(ex){

    }
}

function showProducts(array){
    let html="";
    if(array && array.length == 0){
        $("#products-grid").html("<p class='pt-5 px-2 h5 font-weight-light'>No products to show :(</p>");
        return;
    }
    for(let p of array){
        html += `
        <div class="product-wrapper col-12 col-md-6 col-xl-3 p-4">
            <a class="product" href="index.php?page=product&id=${p.product_id}">
                <div class="border rounded shadow row">
                    <img class="col-12 p-0 rounded" src="assets/images/${p.thumbnail}" alt="${p.product_title}"/>
                    <h5 class="col-12 h4 pt-3 font-weight-light text-dark">${p.product_title}</h5>
                    <div class="col-12 d-flex flex-column justify-content-center text-right p-3 text-primary">
                        <div class="h5 font-weight-light">${formatPrice(Number(p.product_price))}</div>
                        <div class="font-weight-light"><span class="far fa-eye"></span> ${p.product_views}</div>
                    </div>
                </div>
            </a> 
        </div>`;
    }
    $("#products-grid").html(html);
}
function formatPrice(price){
    return price.toLocaleString("en-US",{style: 'currency', currency: 'USD'});
}
function filterChangeDetector(){
    let change = false;
    if($("#products-filters").find("input:checked").length){
        change = true;
    }
    else if ($("#search-products").val() + $("#max-price").val() + $("#min-price").val() + $("#location").val() != ""){
        change = true;
    }
    if(change){
        $("#clear-filters").show();
    }
    else {
        $("#clear-filters").hide();
    }
}
function clearFilters(){
    $("#products-filters input:checkbox").prop("checked", false);
    $("#products-filters input:text, #search-products").val("");
    $(this).hide();
    refreshProducts(1);
}
async function refreshProducts(pageNo = 1, countProducts = true){
    filterChangeDetector();

    let pagination =  $("#paginate-products").val();
    
    let filterObj = {
        "inactive": String($("#inactive")[0].checked),
        "cat_id": category_info.category_id,
        "subcategories": $("#subcategories input:checked").get().map(x=>x.value).join(),
        "genders": $("#genders input:checked").get().map(x=>x.value).join(),
        "conditions": $("#conditions input:checked").get().map(x=>x.value).join(),
        "min_price": $("#min-price").val(),
        "max_price": $("#max-price").val(),
        "user_location": String($("#user-location")[0].checked),
        "location": $("#location").val(),
        "search": $("#search-products").val(),
        "sort": $("#sort-products").val(),
        "pagination": pagination,
        "page_no": pageNo
    };
    if(countProducts){
        filterObj["count_products"] = "true";
    }

    try {
        let response = await ajaxData("models/products/get-products.php", "get", filterObj);
        showProducts(response.products);
        if(countProducts){
            window.productCount = response.product_count;
            showPaginationLinks(pagination, pageNo);
        }
    }
    catch(ex){

    }

}
function showPaginationLinks(pagination, pageNo){

    $("#pagination").html("");
    if(pagination == 0){
        return;
    }
    pageCount = Math.floor(productCount / pagination);
    if(productCount % pagination){
        pageCount++;
    }
    if(pageNo > 1){
        createPageLink(pagination, pageNo-1,false, "product-prev-page", "<span class='fas fa-chevron-left px-2'></span>");
    }
    else if(productCount > 0) {
        
        $("#pagination").append(`<span class="text-black-25 fas fa-chevron-left px-3"></a>`);
    }
    
    for(let i=0; i<pageCount; i++){
        createPageLink(pagination, i+1, i+1 == pageNo);
    }

    if(pageNo < pageCount){
        createPageLink(pagination, pageNo+1,false, "product-next-page", "<span class='fas fa-chevron-right px-2'></span>");
    }
    else if(productCount > 0) {
        $("#pagination").append(`<span class="text-black-25 fas fa-chevron-right px-3"></a>`);
    }
}
function createPageLink(pagination, pageNo, active = false, linkClass = "border ", linkText = false){
    $("#pagination").append(`<a href="#!" class="${linkClass} product-page-link p-2 ${active ? " active" : ""}">${linkText ? linkText : pageNo}</a>`);
    
        $(".product-page-link:last").click(function(){
            $(".product-page-link").removeClass("active");
            $(this).addClass("active");
            refreshProducts(pageNo, false);
            showPaginationLinks(pagination, pageNo);
            $("html").scrollTop($("#products-wrapper").offset().top - 200);
        });
}

function loadSellPage(){

    $("#genders-apply").change(function(){
        if($(this).prop("checked")){
            $("#gender").prop("disabled", false);
            $("label[for=gender]").removeClass("text-black-50");
        }
        else {
            $("#gender").prop("disabled", true);
            $("label[for=gender]").addClass("text-black-50");
        }
    });

    let photosCount = 1;

    $("#add-new-photo").click(function(){

        photosCount++;
        $("#product-photos").append(`
        <div class="product-photo my-2" data-photo-id="${photosCount}">
            <input type="file" class="overflow-hidden" name="photo-${photosCount}"/>
            <a href="#!" class="remove-photo" data-photo-id="${photosCount}"><span class="fas fa-minus-circle text-danger"></span> Remove</a>
        </div>`);
    });

    $(document).on("click", ".remove-photo", function(){

        let photoId = $(this).data("photo-id");
        $(`.product-photo[data-photo-id=${photoId}]`).remove();
    });

    $("#sell-item-form").submit(validateSellItemForm);
}
function validateSellItemForm(e){
    
    resetFormMessages();
    window.forms.error = false;

    let title = $("#product-title");
    let description = $("#product-description");
    let price = $("#product-price");

    let category = $("#product-category");
    let condition = $("#product-condition");
    let gender = $("#gender");

    let photos = $("#product-photos input");

    validateElement(title, forms.title);
    validateElement(description, forms.description);
    validateElement(price, forms.price);

    if($(category).val() == "0"){
        formError(category, "Please select category");
    }
    if($(condition).val() == "0"){
        formError(condition, "Please select condition");
    }
    if($("#genders-apply")[0].checked && $(gender).val() == "0"){
        formError(gender, "Please select gender");
    }

    let allowedExt = ["jpg", "jpeg", "png", "gif"];
    $(photos).each(function(){
        if(this.files.length == 0){
            formError($(this).parent(), "Choose a file.");
        }
        else if(!allowedExt.includes(this.files[0].name.split(".").slice(-1)[0])){
            formError($(this).parent(), "Allowed extensions are: jpg, jpeg, gif, png");
        }
        else if(this.files[0].size > 3 * 1024 * 1024){
            formError($(this).parent(), "Max. size per image: 3MB");
        }
    });

    if(forms.error){
        e.preventDefault();
    }
    
}

function loadProductViewPage(){
    resizeProductImageLinks();
    $(window).resize(resizeProductImageLinks);
    $(".product-image-link").click(changeProductViewImage);
    $("#product-price").html(formatPrice(Number($("#product-price").data("amount"))));
    $("#admin-make-inactive").click(adminMakeInactiveConfirmation);

    if($("#wish-list-toggle").length){
        loadProductViewWishListToggle();
    }

    $("#product-buyer-offer-form").submit(function(e){
        let value = $("#amount").val();
        if(value == "" || Number(value)<0.1){
            e.preventDefault();
            $("#amount").css("border-color", "red");
        }
        
    });
}
function resizeProductImageLinks(){
    $(".product-image-link img").each(function(){
            $(this).css("height", $(this).width()+"px");
    });
}
function changeProductViewImage(){
    let href = $(this).data("href");
    $("#product-image")
        .stop()
        .animate({"opacity":".3"}, 200, "swing", function(){
            $(this).attr("src", href);
        })
        .animate({"opacity":"1"}, 200); 
    
}
function adminMakeInactiveConfirmation(e){
    let confirmation = confirm("Are you sure? You won't be able to revert.");
    if(!confirmation){
        e.preventDefault();
    }
}
async function loadProductViewWishListToggle(){
    try {
        let id = $("#wish-list-toggle").data("id");
        window.wishListStatus = await ajaxData("models/products/get-wish-list-status.php", "get", {"product_id": id});

        refreshWishListIcon();
        $("#wish-list-toggle").click(changeWishListStatus);
    }
    catch(ex){
        $("#wish-list-toggle").remove();
    }
}
function refreshWishListIcon(){
    if(wishListStatus == "true"){
        $(".wish-list-toggle-icon").removeClass("far")
            .addClass("fas");
        $(".wish-list-toggle-text").text("Remove from wish list");
    }
    else if(wishListStatus == "false") {
        $(".wish-list-toggle-icon").removeClass("fas")
            .addClass("far");
        $(".wish-list-toggle-text").text("Add to wish list");
    }
    else {
        $("#wish-list-toggle").remove();
    }
}
async function changeWishListStatus(){
    try{
        let id = $("#wish-list-toggle").data("id");
        window.wishListStatus = await ajaxData("models/products/set-wish-list-status.php", "get", {"product_id": id, "current_status": wishListStatus});

        refreshWishListIcon();
    }
    catch(ex){
        $("#wish-list-toggle").remove();
    }

}


function loadChatPage(){
    window.messageCount = 0;
    window.loadingChatFirstTime = true;
    setTimeout(refreshChatBoxTimeout, 1);
    $("#chat-buyer-offer, #chat-desired-price").each(function(){
        $(this).text(formatPrice(Number($(this).data("amount"))));
    });
    $("#btn-send-message").click(sendMessage);
    $("#tb-send-message").keyup(function(event) {
        if (event.keyCode === 13) {
            sendMessage();
        }
    });
}
function refreshChatBoxTimeout(){

    refreshChatBox();

    let delay = 3000 + Math.floor(Math.random() * 2000);
    setTimeout(refreshChatBoxTimeout, delay);
}
async function refreshChatBox(){
    let offerId = $("#chat-box").data("offer-id");
    try {
        let response = await ajaxData("models/offers/show-m-e-s-s-a-g-e-s.php", "GET", {"offer-id":offerId});
        if(response && response.messages.length){
            if(!(response.messages.length > messageCount)){
                return;
            }
            let newMessages = response.messages.slice(messageCount);
            messageCount = response.messages.length;
            let html = "";
            for(let message of newMessages){
                if(message.sender_id == response.user_id){
                    if(loadingChatFirstTime){
                        html += `<div class="message clearfix p-2">
                        <div class="message-sender w-75 w-md-50 text-muted text-right float-right">you:</div>
                        <div class="message-content w-75 w-md-50 text-right float-right">${message.message_text}</div>
                    </div>`;
                    }
                }

                else {
                    html += `<div class="message clearfix p-2">
                    <div class="message-sender w-75 w-md-50 text-primary text-left">${message.sender_username}:</div>
                    <div class="message-content w-75 w-md-50 text-left">${message.message_text}</div>
                </div>`;
                }
            }
            $("#chat-box").append(html);
            $("#chat-box")[0].scrollTop = $("#chat-box")[0].scrollHeight;
            
            
        }
        else {
            $("#chat-box").html("<p class='no-messages p-2 font-weight-light'>No messages yet.</p>");
        }
        loadingChatFirstTime = false;
    }
    catch(ex){
        $("#chat-box").html("<p class='no-messages p-2 font-weight-light'>Error displaying messages.</p>");
    }
}
async function sendMessage(){
    let text = $("#tb-send-message").val();
    let offerId = $("#chat-box").data("offer-id");
    $("#tb-send-message").val("");

    try {
        let response = await ajaxData("models/offers/send-m-e-s-s-a-g-e.php", "POST", {"offer-id": offerId, "text": text});
        if(response.success){
            $(".no-messages").remove();
            $("#chat-box").append(`<div class="message clearfix p-2">
                <div class="message-sender w-75 w-md-50 text-muted text-right float-right">you:</div>
                <div class="message-content w-75 w-md-50 text-right float-right">${text}</div>
            </div>`);
            $("#chat-box")[0].scrollTop = $("#chat-box")[0].scrollHeight;
            return;
        }
    }
    catch(ex){
        console.log(ex);
    }
    $(".error-sending-message").remove();
    $("<p class='text-danger error-sending-message container mx-auto'>Error sending message. Refresh the page and try again later.</p>").insertAfter($("#btn-send-message").parent().parent());

    
}

function loadAdminPage(){
    $(".progress-bar").each(function(){
        $(this).width($(this).attr("aria-valuenow")+"%");
    });
    $(".admin-panel-link").click(function(){
        let target = $(this).data("target");
        $(".admin-panel-link").removeClass("active");
        $(this).addClass("active");
        $(".admin-panel").addClass("d-none");
        $(target).removeClass("d-none");
    });
    showAdminUserPanel();
    $("#search-users").on("change", showAdminUserPanel);
}

async function showAdminUserPanel(){
    let search = $("#search-users").val();
    try {
        window.users = await ajaxData("models/admin/get-users.php", "post", {"search": search});
        insertUserData();

        $(".show-change-pw").click(function(){
            let id = $(this).data("id");
            $(`.change-pw-container[data-id=${id}]`).stop().toggle(200);
            $(this).toggleClass("active");
        });
        $(".show-ban-user").click(function(){
            let id = $(this).data("id");
            $(`.ban-user-container[data-id=${id}]`).stop().toggle(200);
            $(this).toggleClass("active");
        });
        $(".show-unlock-user").click(function(){
            let id = $(this).data("id");
            $(`.unlock-user-container[data-id=${id}]`).stop().toggle(200);
            $(this).toggleClass("active");
        });
    
    }
    catch(ex){
        $("#admin-users").html(`<p class="ajax-error">Can't fetch users. Try again later.</p>`);
        console.log(ex);
    }

}

function insertUserData(){

    let html="";
    if(users && users.length){
        for(let user of users){
            html += `
                <div class="user-info row m-0 py-3 align-items-center">
                    <div class="col-1 user-id">${user.user_id}</div>
                    <div class="col-2 username">${user.username}</div>
                    <div class="col-3 user-email">${user.email}</div>
                    <div class="col-2 user-full-name">${user.full_name}</div>
                    <div class="col-2 user-date-created">${user.user_date_created}</div>
                    <div class="col-2 text-right">
                        <a href="#!" class="show-change-pw btn btn-primary" data-id="${user.user_id}" class="btn btn-primary"><span class="fas fa-key"></span></a>
                        <a href="#!" data-id="${user.user_id}" class="btn btn-${user.ban_description !== null ?"danger" : "success"} show-ban-user"><span class="fas fa-ban"></span></a>
                        <a href="#!" data-id="${user.user_id}" class="btn btn-${user.unlock_code !== null ?"danger" : "success"} show-unlock-user"><span class="fas fa-lock"></span></a>
                    </div>
                    <div class="change-pw-container col-12 m-2 text-right" data-id="${user.user_id}">
                        <form action="models/admin/change-user-password.php" method="post">
                            <input type="hidden" name="id" value="${user.user_id}"/>
                            <input type="password" placeholder="New password" class="form-control  d-inline w-25" name="password" data-title="password"/>
                            <button type ="submit" href="#!" class="btn btn-primary align-baseline">Change</button>
                        </form>
                    </div>
                    <div class="ban-user-container col-12 m-2 text-right" data-id="${user.user_id}">`;
                    if(user.ban_description === null){
                        html+=`<form action="models/admin/change-user-ban-status.php" method="get">
                            <input type="hidden" name="id" value="${user.user_id}"/>
                            <input type="text" name="description" placeholder="Ban reason" class="form-control  d-inline w-25" data-title="reason"/>
                            <button type ="submit" href="#!" class="btn btn-primary align-baseline">Ban</button>
                        </form>`;
                    }
                    else {
                        html += `This user is banned. <a href="models/admin/change-user-ban-status.php?id=${user.user_id}" class="btn btn-primary">Unban</a>`;
                    }
                    html+=`</div>
                    <div class="unlock-user-container col-12 m-2 text-right" data-id="${user.user_id}">
                        ${user.unlock_code !== null ? "This account is locked by security measures. <a href='models/admin/unlock-user.php?id="+ user.user_id +"' class='unlock-user btn btn-primary' data-id='" + user.user_id +"'>Unlock</a>" : "This account is not locked by security measures."}
                        
                    </div>
                </div>`;
        }
    }
    else {
        html+= `<p class="m-4 font-weight-light h5">No users found.</p>`;
    }
    $("#users").html(html);
}

function loadContactPage(){
    $("#contact-form").submit(function(e){
        
        resetFormMessages();
        window.forms.error = false;

        let name = $("#name");
        let email = $("#email");
        let message = $("#message");

        validateElement(name, forms.name);
        validateElement(email, forms.email);
        validateElement(message, forms.message);

        if(forms.error){
            e.preventDefault();
        }
    });
}

function loadRegisterPage(){

    $("#register-form").submit(function(e){
        
        resetFormMessages();
        window.forms.error = false;

        let fname = $("#full-name");
        let email = $("#email");
        let username = $("#username");
        let city = $("#city");
        let country = $("#country");
        let pw = $("#password");

        validateElement(fname, forms.fullName);
        validateElement(email, forms.email);
        validateElement(username, forms.username);
        validateElement(city, forms.city);
        validateElement(country, forms.country);
        validateElement(pw, forms.password);
        
        if($("#password-repeat").val() != $("#password").val()){
            formError($("#password-repeat"), "Passwords do not match.");
        }

        if(forms.error){
            e.preventDefault();
        }
    });
}

function loadLoginPage(){

    $("#login-form").submit(function(e){
        
        resetFormMessages();
        window.forms.error = false;

        if($("#username").val().length < 3){
            formError($("#username"), "Please enter a valid username.");
        }
        if($("#password").val().length < 3){
            formError($("#password"), "Please enter a valid password.");
        }

        if(forms.error){
            e.preventDefault();
        }
    });
}
<?php

    
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=Mihailo_Ilic_INFO.doc");

    $word_string = "<table>
        <thead>
            <tr>
                <th><b>Mihailo Ilic</b> 41/19</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Hi. I'm a web developer from Serbia. I've recently started studying IT/Web programming at <a href=\"https://ict.edu.rs/\">ICT College</a> because I've always been interested in computers and technology.</td>
            </tr>
            <tr>
                <td>Although my skills are limited at this moment, I will continuously try to improve them through my studies, projects etc. You can check my recent projects and learn more about me by visiting my <a href=\"https://mihailoilic.github.io/portfolio/\"> portfolio website</a>.</td>
            </tr>
        </tbody>
    </table>";

    echo $word_string;
   
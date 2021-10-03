<?php
//"authorName":"yuss"
//"contactAuthor":"yus17726@gmail.com"
//"facebookAuthor":"http://facebook.com/yus.127.0.0.1"

print "
             /\
            ( ;`~v/~~~ ;._
         ,/'\"/^) ' < o\  '\".~'\\\--,
       ,/\",/W  u '`. ~  >,._..,   )'
      ,/'  w  ,U^v  ;//^)/')/^\;~)'
   ,/\"'/   W` ^v  W |;         )/'
 ;''  |  v' v`\" W }  \\
\"    .'\    v  `v/^W,) '\)\.)\/)
                   `\   ,/,)'   ''')/^\"-;'
                        \
                         '\". _
-------------------------------------------
//Beringas is a WebShell Checker Tools and Break The Password
//Created by Yuss
//If you have a list, break your list with [ENTER] and type your file list name and you can type any file list name like this -> list1.txt|list2.txt (explode it with | symbol)
//If you haven't a list you just type the url only bitch
//Then if the WebShell status is Founded you can choose if you want to crack the tools or not 
";

echo "Enter the target : ";
$list = trim(fgets(STDIN));

function crotz($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $output = strtolower(curl_exec($ch));
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    preg_match("|type='password' name=\"(.*?)\"|", $output, $password1);
    preg_match("|<input type='pass' name=\"(.*?)\"|", $output, $pass1);
    preg_match("|type=\"password\" name=\"(.*?)\"|", $output, $password2);
    preg_match("|<input type=\"pass\" name=\"(.*?)\"|", $output, $pass2);
    preg_match("|File Manager|", $output, $fm);
    preg_match("|<input type=\"file\" |", $output, $upload);

    if($status == 200) 
    {
        echo "\n[Notice] Status is ".$status;
        echo "\n[Notice] Checking the form.";
        
        if(!empty($fm) || !empty($upload))
        {
            echo "\n[GOOD] Looks like this site have an upload form.";
        }
        else if(!empty($password1) || !empty($pass1) || !empty($password2) || !empty($pass2))
        {
            echo "\n[GOOD] Looks like this site have a password form.";
        }
        else
        {
            echo "\n[WARNING] Sorry, there is nothing to do.";
        }
    }
    else 
    {
        echo "\n[BAD] Sorry, status is ".$status.".";
    }
}

function splitz($list, $curling = 'N')
{
    $open = fopen($list, "r");
    $size = filesize($list);
    $read = fread($open, $size);
    $url  = explode("\n", $read);

    foreach($url as $host):
        crotz($host);
    endforeach;
}

(strpos($list, ".txt")) ? splitz($list) : crotz($list);
?>

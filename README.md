# Online-Notes
A public note library that restore everyone's intelligent.
Learning is fun, you can serach almost everything from the net.
But when it comes to memorizing the article read two weeks ago, it's impossible to memorize all the word without a wrong note.
So Online-Notes takes the field, register a account and you can take notes from every website you want.
This program features login、note_list and permission function.
You can create your own notes and watch others' note.
Don't worry, others can't delete your own notes so you can take it easy and leave your mind to all the fun things.

# Pre-setting
The procedure below demostrates the pre-setting before starting your creation. 
## __1.__Install PHP
Ubantu or linux
'sudo apt install php libapache2-mod-php php-mysql'

windows
Go to https://windows.php.net/download
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/download_PHP.PNG)

Download the zip file, and unzip it.
Go to environment variable.

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/environment%20variable1.PNG)


Select Path, and click edit.

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/environment%20variable2.PNG)


Create a new path, and type in the unzip file path and click confirm.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/environment%20variable3.PNG)
## __2.__Install XAMPP
Go to https://www.apachefriends.org/zh_tw/download.html

## __3.__Create the database
Go to C:/xampp, start xampp-control.exe.
Click start let the apache and MySQL turn green.

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/Xampp-control-panel.PNG)

Open your Web browser, type in localhost/PHPmyadmin
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/PHPmyadmin.PNG)

Create a database named notes and note、note_history、user、user_history datatable.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/sub%20database.PNG)

Setting the datatable below.
### note

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/note.png)

### note_history

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/note_history.PNG)

### user

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/user.PNG)

### user_history

![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/user_history.PNG)

## Setting password for MySQL
Go to localhost/phpmyadmin.
Click the user account, and click the create new user account.

Go to Xampp control panel, click phpMyAdmin.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/Setting%20phpmyadmin.png)

Find $cfg['Servers'][$i]['AllowNoPassword'] = True, and change it to False.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/Setting%20for%20password.PNG)

It's better to set a user to enter database, because many data is restored in it.
## How to use
Start your xampp and click the start button next to Apache and MySQL.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/Xampp-control-panel.PNG)

Download the all files in this project, and put it into C:/xampp/htdocs.
Open your web borwser, and enter localhost.
It'll go to the index.php directly.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/index.PNG)

You can register a new user account.
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/register.PNG)

Login the Online-notes, there you have it.
You can enjoy creating your own notes!!
![image](https://github.com/Yorkxe/Online-Notes/blob/main/Pics/welcome.PNG)

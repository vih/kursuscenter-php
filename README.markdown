kursuscenter.vih.dk
==

PHP source code for [Vejle Idrætshøjskole's kursuscenter](http://kursuscenter.vih.dk)

Installation
--

Elevforeningen is currently served up by [Intraface](http://intraface.dk). To really check the page on you own server, you need the credentials for their site on intraface.

If you would like to install dependencies, you can do the following:

    php makepackage.php make
    
This will create a package.xml to use for the pear installer. From the directory where the package.xml was created, do the following:

    pear package
    
Now a pear installable package has been created:

    pear install VIH_Kursuscenter-x.x.x.tgz
    
Feedback appreciated.
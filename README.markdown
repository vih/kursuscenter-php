[kursuscenter.vih.dk](http://kursuscenter.vih.dk/)
==

PHP source code for [Vejle Idrætshøjskole's kursuscenter](http://kursuscenter.vih.dk)

Installation
--

The site is currently served by [Intraface](http://intraface.dk) with [konstrukt.dk](http://konstrukt.dk) as the framework. To really check the page on you own server, you need the credentials for the site on intraface.

If you like to do a local installation, it best way right now is to do the following:

    pear channel-discover pear.phing.info
    pear install phing/phing
    
After installing phing, you should be able to just run:

    phing make
    
That will create a pear package, which will take care of installing all the dependencies when installing it.

    pear install VIH_Kursuscenter-x.x.x.tgz
    
Feedback appreciated.
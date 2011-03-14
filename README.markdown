[kursuscenter.vih.dk](http://kursuscenter.vih.dk/)
==

###This code is deprecated. See the new [Drupal 7 site instead](http://github.com/vih/kursuscenter.vih.dk-deploy)###

PHP source code for [Vejle Idrætshøjskole's kursuscenter](http://kursuscenter.vih.dk)

Installation
--

The site is currently served by [Intraface](http://intraface.dk) with [konstrukt.dk](http://konstrukt.dk) as the framework. To really check the page on you own server, you need the intraface api credentials for the site.

If you like to do a local installation, do the following:

    pear channel-discover pear.phing.info
    pear install phing/phing
    
After installing phing, run:

    phing make
    
That will create a pear package, which will take care of installing all the dependencies for the site.

    pear install VIH_Kursuscenter-x.x.x.tgz
    
Feedback appreciated.
<?php
require_once 'config.local.php';

require_once 'Ilib/ClassLoader.php';
require_once 'konstrukt/konstrukt.inc.php';
require_once 'bucket.inc.php';

class VIH_Kursuscenter_Root extends k_Component
{
    protected $template;
    protected $cms;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        if ($name == 'nyhedsbrev') {
            return 'VIH_Kursuscenter_Nyhedsbrev';
        }
        return 'VIH_Kursuscenter_PageHandler';
    }

    function document()
    {
        return $this->document;
    }

    function execute()
    {
        return $this->wrap(parent::execute());
    }

    function wrapHtml($content)
    {
        $tpl = $this->template->create('main');
        return $tpl->render($this, array('content' => $content));
    }

    function renderHtml()
    {
        return new k_SeeOther('forside');
    }
}

class VIH_Kursuscenter_Nyhedsbrev extends k_Component
{
    protected $newsletter;
    protected $form = null;

    function __construct(k_TemplateFactory $template, IntrafacePublic_Newsletter_Client_XMLRPC $newsletter)
    {
        $this->template = $template;
        $this->newsletter = $newsletter;
    }

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $form = new HTML_QuickForm('', 'post', $this->url());
        $form->addElement('text', 'email', 'E-mail');
        $radio[0] =& HTML_QuickForm::createElement('radio', null, null, 'tilmeld', '1');
        $radio[1] =& HTML_QuickForm::createElement('radio', null, null, 'frameld', '2');
        $form->addGroup($radio, 'mode', null, null);
        $form->addElement('submit', null, 'Gem');
        $form->setDefaults(array(
            'mode' => 1
        ));
        $form->addRule('email', 'Du skal skrive en e-mail-adresse', 'required', null);

        return $this->form = $form;
    }

    function renderHtml()
    {
        $data = array(
            'headline' => 'Nyhedsbrev',
            'picture' => '',
            'html' => '<p class="notice">'.htmlentities($this->query('flare')).'</p><p>Vi udsender seks-otte nyhedsbreve om året. Nyhedsbrevene fortæller om de vigtigste nyheder fra Vejle Idrætshøjskoles elevforening. Nyhedsbrevet sendes i tekstformat.</p>' . $this->getForm()->toHtml()
        );

        $tpl = $this->template->create('page');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        if ($this->getForm()->validate()) {
            if ($this->body('mode') == 1) {
                if ($this->newsletter->subscribe($this->body('email'), $_SERVER['REMOTE_ADDR'])) {
                    return new k_SeeOther($this->url(null, array('flare' => 'Du er tilmeldt nyhedsbrevet.')));
                } else {
                    return new k_SeeOther($this->url(null, array('flare' => 'Du blev ikke tilmeldt. Måske har ud indtastet din e-mail forkert.')));
                }
            } elseif ($this->body('mode') == 2) {
                if ($this->newsletter->unsubscribe($this->body('email'))) {
                    return new k_SeeOther($this->url(null, array('flare' => 'Du er nu frameldt nyhedsbrevet.')));
                } else {
                    return new k_SeeOther($this->url(null, array('flare' => 'Du blev ikke frameldt. Måske har ud indtastet din e-mail forkert.')));
                }
            }
        }
        return $this->render();
    }
}

class VIH_Kursuscenter_PageHandler extends k_Component
{
    protected $cms;

    function __construct(k_TemplateFactory $template, IntrafacePublic_CMS $cms)
    {
        $this->template = $template;
        $this->cms = $cms;
    }

    function renderHtml()
    {
        $page = $this->cms->getPage($this->name());

        $navigation = $page['navigation_toplevel'];


        if (!empty($page['http_header_status']) AND $page['http_header_status'] == 'HTTP/1.0 404 Not Found') {
            throw new k_PageNotFound();
        }

        $parser = new IntrafacePublic_CMS_HTML_Parser($page);
        $this->document->setTitle($page['title']);
        $this->document->style = $page['css'];
        $this->document->keywords = $page['keywords'];
        $this->document->description = $page['description'];
        $this->document->navigation['html'] = $parser->parseNavigation();
        $this->document->navigation['toplevel'] = $page['navigation_toplevel'];
        if (!empty($page['navigation_sublevel'])) {
            $this->document->navigation['sublevel'] = $page['navigation_sublevel'];
        } else {
            $this->document->navigation['sublevel'] = array();
        }
        $sections = $parser->getSections();

        $headline = $parser->getSection('headline');
        $picture = $parser->getSection('picture');
        $html = $parser->getSection('html');

        $data = array(
            'headline' => $headline['text'],
            'html' => $html['html'],
            'picture' => $picture['picture']
        );

        $tpl = $this->template->create('page');
        return $tpl->render($this, $data);
    }

}

class VIH_Kursuscenter_Factory
{
    public $template_dir;
    public $cache_dir;

    function new_k_TemplateFactory($c)
    {
        return new k_DefaultTemplateFactory($this->template_dir);
    }

    function new_IntrafacePublic_Newsletter_Client_XMLRPC()
    {
        $list_id = 17;
        $credentials = array("private_key" => $GLOBALS["intraface_private_key"], "session_id" => uniqid());
        return new IntrafacePublic_Newsletter_Client_XMLRPC($credentials, $list_id);
    }

    function new_IntrafacePublic_CMS_Client_XMLRPC()
    {
        $credentials = array("private_key" => $GLOBALS["intraface_private_key"], "session_id" => uniqid());
        return new IntrafacePublic_CMS_Client_XMLRPC($credentials, $GLOBALS["intraface_site_id"], false);
    }

    function new_Cache_Lite()
    {
        $options = array(
       		"cacheDir" => $this->cache_dir,
       		"lifeTime" => 3600
        );
        return new Cache_Lite($options);
    }

    function new_IntrafacePublic_CMS($c)
    {
        return new IntrafacePublic_CMS($this->new_IntrafacePublic_CMS_Client_XMLRPC($c), $this->new_Cache_Lite($c));
    }

}

class VIH_Kursuscenter_Document extends k_Document
{
    public $navigation;
    public $description;
    public $keywords;
    public $style;
}

$factory = new VIH_Kursuscenter_Factory();
$factory->template_dir = $GLOBALS['template_dir'];
$container = new bucket_Container($factory);

if (realpath($_SERVER['SCRIPT_FILENAME']) == __FILE__) {
  $components = new k_InjectorAdapter($container, new VIH_Kursuscenter_Document);
  k()
    ->setComponentCreator($components)
    ->run('VIH_Kursuscenter_Root')
    ->out();
}

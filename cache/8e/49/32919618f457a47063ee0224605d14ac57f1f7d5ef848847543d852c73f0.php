<?php

/* home/index.php */
class __TwigTemplate_8e4932919618f457a47063ee0224605d14ac57f1f7d5ef848847543d852c73f0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?php require_once('templates/layout/header.php'); ?>
<h1>Pagina inicial</h1>
<br/><br/><br/>
<?php require_once(\"templates/layout/footer.php\"); ?>";
    }

    public function getTemplateName()
    {
        return "home/index.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

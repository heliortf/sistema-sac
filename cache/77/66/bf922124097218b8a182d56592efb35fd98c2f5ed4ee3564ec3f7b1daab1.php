<?php

/* home/index.html.twig */
class __TwigTemplate_7766bf922124097218b8a182d56592efb35fd98c2f5ed4ee3564ec3f7b1daab1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout/site.html.twig", "home/index.html.twig", 1);
        $this->blocks = array(
            'titulo' => array($this, 'block_titulo'),
            'conteudo' => array($this, 'block_conteudo'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/site.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_titulo($context, array $blocks = array())
    {
        echo "Titulo do home/index";
    }

    // line 4
    public function block_conteudo($context, array $blocks = array())
    {
        // line 5
        echo "    <div class=\"row\">
        <div class=\"col-md-4 col-md-offset-4\">
            <form class=\"form form-horizontal form-login\">        
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Login:</label>
                    <div class=\"col-sm-10\">
                        <input type=\"text\" name=\"login\" class=\"form-control\" id=\"login\" value=\"\" />
                    </div>
                </div>
                <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">Senha:</label>
                    <div class=\"col-sm-10\">
                        <input type=\"text\" name=\"senha\" class=\"form-control\" id=\"senha\" value=\"\" />
                    </div>
                </div>
                <div class=\"form-group\">
                    <div class=\"col-sm-offset-2 col-sm-10\">
                        <button type=\"submit\" class=\"btn btn-default\">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "home/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 5,  35 => 4,  29 => 2,  11 => 1,);
    }
}

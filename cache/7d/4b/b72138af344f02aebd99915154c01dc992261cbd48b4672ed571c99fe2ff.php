<?php

/* layout/site.html.twig */
class __TwigTemplate_7d4bb72138af344f02aebd99915154c01dc992261cbd48b4672ed571c99fe2ff extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'titulo' => array($this, 'block_titulo'),
            'css' => array($this, 'block_css'),
            'menu_principal' => array($this, 'block_menu_principal'),
            'conteudo' => array($this, 'block_conteudo'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>
    <head>
        <title>";
        // line 3
        $this->displayBlock('titulo', $context, $blocks);
        echo "</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap-3.3.4-dist/css/bootstrap.min.css\" />
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap-3.3.4-dist/css/bootstrap-theme.min.css\" />
        <link rel=\"stylesheet\" href=\"//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">        
        <link rel=\"stylesheet/less\" type=\"text/css\" href=\"css/estilo.less\" />
        ";
        // line 8
        $this->displayBlock('css', $context, $blocks);
        // line 9
        echo "    </head>
    <body>
        <div class=\"container-fluid effort site\">
            <div class=\"row topo\">
                <div class=\"col-md-3 logotipo\">                    
                    <div class=\"row\">      
                        <div class=\"col-md-11 col-md-offset-1\">
                            <i class=\"fa fa-chevron-right claro\"></i>
                            <i class=\"fa fa-chevron-right escuro\"></i>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-11 col-md-offset-1\">
                            <h1>Effort</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"row menu\">
                ";
        // line 28
        $this->displayBlock('menu_principal', $context, $blocks);
        // line 29
        echo "            </div>
            <div class=\"row conteudo\">
                <div class=\"col-md-12\">
                    ";
        // line 32
        $this->displayBlock('conteudo', $context, $blocks);
        // line 33
        echo "                </div>
            </div>
        </div>        
        <script type=\"text/javascript\" src=\"js/lib/jquery/jquery-1.11.3.min.js\"></script>
        <script type=\"text/javascript\" src=\"css/bootstrap-3.3.4-dist/js/bootstrap.min.js\"></script>
        <script type=\"text/javascript\" src=\"js/lib/less/lesscss.js\"></script>
        ";
        // line 39
        $this->displayBlock('scripts', $context, $blocks);
        // line 40
        echo "    </body>
</html>";
    }

    // line 3
    public function block_titulo($context, array $blocks = array())
    {
        echo "Titulo";
    }

    // line 8
    public function block_css($context, array $blocks = array())
    {
    }

    // line 28
    public function block_menu_principal($context, array $blocks = array())
    {
    }

    // line 32
    public function block_conteudo($context, array $blocks = array())
    {
    }

    // line 39
    public function block_scripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout/site.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  104 => 39,  99 => 32,  94 => 28,  89 => 8,  83 => 3,  78 => 40,  76 => 39,  68 => 33,  66 => 32,  61 => 29,  59 => 28,  38 => 9,  36 => 8,  28 => 3,  24 => 1,);
    }
}

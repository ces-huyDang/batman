<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/blog/templates/carousel.html.twig */
class __TwigTemplate_2b05baa99527ef8df33adb8bcee1382d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"position-relative\">
  <div class=\"card w-95 position-absolute start-5\">
    <div class=\"card-body\">
      <div id=\"carousel\"></div>
      <a id=\"left-arrow\" class=\"btn btn-dark btn-lg rounded-circle position-absolute top-50 start-0 translate-middle \">❮</a>
      <a id=\"right-arrow\" class=\"btn btn-dark btn-lg rounded-circle position-absolute top-50 start-100 translate-middle\">❯</a>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/blog/templates/carousel.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"position-relative\">
  <div class=\"card w-95 position-absolute start-5\">
    <div class=\"card-body\">
      <div id=\"carousel\"></div>
      <a id=\"left-arrow\" class=\"btn btn-dark btn-lg rounded-circle position-absolute top-50 start-0 translate-middle \">❮</a>
      <a id=\"right-arrow\" class=\"btn btn-dark btn-lg rounded-circle position-absolute top-50 start-100 translate-middle\">❯</a>
    </div>
  </div>
</div>
", "modules/custom/blog/templates/carousel.html.twig", "/app/web/modules/custom/blog/templates/carousel.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}

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

/* themes/lando_blog/templates/page/page.html.twig */
class __TwigTemplate_3acde4e5685caab9a7100d417d911d66 extends Template
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
        echo "<div class=\"container-fluid\">
  <div class=\"row\">
    <div class=\"card header bg-light \">
      <div class=\"p-5 text-center\">";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 4), 4, $this->source), "html", null, true);
        echo "</div>
    </div>
    <div id=\"page-menu\" class=\"menu menu-bg-light rounded\">
      <div>";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 7), 7, $this->source), "html", null, true);
        echo "</div>
    </div>
    ";
        // line 9
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured", [], "any", false, false, true, 9)) {
            // line 10
            echo "      <div class=\"featured mb-24\">
        <div class=\"col-12\">
          ";
            // line 12
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "featured", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
            echo "
        </div>
      </div>
    ";
        }
        // line 16
        echo "  </div>
  <div class=\"row mt-5\">
    <div class=\"col-3\">";
        // line 18
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
        echo "</div>
    <div class=\"col-6\">";
        // line 19
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 19), 19, $this->source), "html", null, true);
        echo "</div>
    <div class=\"col-3\">";
        // line 20
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
        echo "</div>
  </div>
  <div class=\"row mt-5\">
    <div class=\"card footer bg-light\">
      <div class=\"text-center p-5\">
        ";
        // line 25
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 25), 25, $this->source), "html", null, true);
        echo "
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/lando_blog/templates/page/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 25,  80 => 20,  76 => 19,  72 => 18,  68 => 16,  61 => 12,  57 => 10,  55 => 9,  50 => 7,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"container-fluid\">
  <div class=\"row\">
    <div class=\"card header bg-light \">
      <div class=\"p-5 text-center\">{{ page.header }}</div>
    </div>
    <div id=\"page-menu\" class=\"menu menu-bg-light rounded\">
      <div>{{ page.primary_menu }}</div>
    </div>
    {% if page.featured %}
      <div class=\"featured mb-24\">
        <div class=\"col-12\">
          {{ page.featured }}
        </div>
      </div>
    {% endif %}
  </div>
  <div class=\"row mt-5\">
    <div class=\"col-3\">{{ page.sidebar_first }}</div>
    <div class=\"col-6\">{{ page.content }}</div>
    <div class=\"col-3\">{{ page.sidebar_second }}</div>
  </div>
  <div class=\"row mt-5\">
    <div class=\"card footer bg-light\">
      <div class=\"text-center p-5\">
        {{ page.footer }}
      </div>
    </div>
  </div>
</div>
", "themes/lando_blog/templates/page/page.html.twig", "/app/web/themes/lando_blog/templates/page/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 9);
        static $filters = array("escape" => 4);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
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

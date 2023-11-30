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

/* modules/custom/blog/templates/score-block.html.twig */
class __TwigTemplate_1c4ed33c6b5d4fb844b349e2e6650b7e extends Template
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
  ";
        // line 2
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "scores", [], "any", false, false, true, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["score"]) {
            // line 3
            echo "    <div class=\"row mt-2\">
      <div class=\"col-2\">
        <div id=\"square\" class=\"square row bg-success\">
          <div class=\"text-center text-white pt-1\">
            <span id=\"average-score\">";
            // line 7
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_round($this->sandbox->ensureToStringAllowed((($__internal_compile_0 = $context["score"]) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["score"] ?? null) : null), 7, $this->source), 1), "html", null, true);
            echo "</span>
          </div>
        </div>
      </div>
      <div class=\"col-8\">
        <div class=\"pt-2\">
          <span id=\"average-score\">
            ";
            // line 14
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_1 = $context["score"]) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["post_name"] ?? null) : null), 14, $this->source), "html", null, true);
            echo "</span>
        </div>
      </div>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['score'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/blog/templates/score-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 19,  62 => 14,  52 => 7,  46 => 3,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"container-fluid\">
  {% for score in data.scores %}
    <div class=\"row mt-2\">
      <div class=\"col-2\">
        <div id=\"square\" class=\"square row bg-success\">
          <div class=\"text-center text-white pt-1\">
            <span id=\"average-score\">{{ score['score']|round(1) }}</span>
          </div>
        </div>
      </div>
      <div class=\"col-8\">
        <div class=\"pt-2\">
          <span id=\"average-score\">
            {{ score['post_name'] }}</span>
        </div>
      </div>
    </div>
  {% endfor %}
</div>
", "modules/custom/blog/templates/score-block.html.twig", "/app/web/modules/custom/blog/templates/score-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 2);
        static $filters = array("escape" => 7, "round" => 7);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['escape', 'round'],
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

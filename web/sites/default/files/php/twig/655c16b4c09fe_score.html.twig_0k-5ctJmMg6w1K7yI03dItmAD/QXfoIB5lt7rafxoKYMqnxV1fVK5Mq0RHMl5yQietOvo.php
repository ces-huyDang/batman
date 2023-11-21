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

/* modules/custom/blog/templates/score.html.twig */
class __TwigTemplate_2f8c8d904f518ae71370b9699ced10f5 extends Template
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
        echo "<div class=\"card\">
  <div class=\"card-body\">
    <h3>
      Score
    </h3>
    <hr>
    <div id=\"user-score\" class=\"row\">
      <div class=\"col-9\">
        <span class=\"font-mono\">
          USER SCORE
        </span>
        <br>
        <span class=\"fw-medium\">Average</span>
        <br>
        <span class=\"text-decoration-underline\">Based on
          <span id=\"voted-users\"></span>
          User Ratings</span>
      </div>
      <div class=\"col-3\">
        <div id=\"square\" class=\"square row\">
          <div class=\"score pt-2 text-center col-12\">
            <span id=\"average-score\"></span>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class=\"row\">
      <div class=\"col-9\">
        <span class=\"font-mono\">
          MY SCORE
        </span>
        <br>
        <span id=\"noti\" class=\"fw-medium\">Hover and click to give a rating</span>
        <br>
        <div id=\"rating-btn\">
          <div id=\"btn-group\" class=\"btn-group\" role=\"group\">
            ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 10));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 39
            echo "              ";
            if (($context["i"] <= 3)) {
                // line 40
                echo "                <button id=";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["i"], 40, $this->source), "html", null, true);
                echo " type=\"button\" class=\"rate-btn btn btn-outline-danger\"></button>
              ";
            } elseif (((            // line 41
$context["i"] > 3) && ($context["i"] <= 6))) {
                // line 42
                echo "                <button id=";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["i"], 42, $this->source), "html", null, true);
                echo " type=\"button\" class=\"rate-btn btn btn-outline-warning\"></button>
              ";
            } else {
                // line 44
                echo "                <button id=";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["i"], 44, $this->source), "html", null, true);
                echo " type=\"button\" class=\"rate-btn btn btn-outline-success\"></button>
              ";
            }
            // line 46
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "          </div>
        </div>
      </div>
      <div id=\"rating-score\" class=\"col-3\"></div>
      <div id=\"confirm-btn\"></div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/blog/templates/score.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 47,  104 => 46,  98 => 44,  92 => 42,  90 => 41,  85 => 40,  82 => 39,  78 => 38,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"card\">
  <div class=\"card-body\">
    <h3>
      Score
    </h3>
    <hr>
    <div id=\"user-score\" class=\"row\">
      <div class=\"col-9\">
        <span class=\"font-mono\">
          USER SCORE
        </span>
        <br>
        <span class=\"fw-medium\">Average</span>
        <br>
        <span class=\"text-decoration-underline\">Based on
          <span id=\"voted-users\"></span>
          User Ratings</span>
      </div>
      <div class=\"col-3\">
        <div id=\"square\" class=\"square row\">
          <div class=\"score pt-2 text-center col-12\">
            <span id=\"average-score\"></span>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class=\"row\">
      <div class=\"col-9\">
        <span class=\"font-mono\">
          MY SCORE
        </span>
        <br>
        <span id=\"noti\" class=\"fw-medium\">Hover and click to give a rating</span>
        <br>
        <div id=\"rating-btn\">
          <div id=\"btn-group\" class=\"btn-group\" role=\"group\">
            {% for i in 0..10 %}
              {% if i <= 3 %}
                <button id={{ i }} type=\"button\" class=\"rate-btn btn btn-outline-danger\"></button>
              {% elseif i > 3 and i <=6 %}
                <button id={{ i }} type=\"button\" class=\"rate-btn btn btn-outline-warning\"></button>
              {% else %}
                <button id={{ i }} type=\"button\" class=\"rate-btn btn btn-outline-success\"></button>
              {% endif %}
            {% endfor %}
          </div>
        </div>
      </div>
      <div id=\"rating-score\" class=\"col-3\"></div>
      <div id=\"confirm-btn\"></div>
    </div>
  </div>
</div>
", "modules/custom/blog/templates/score.html.twig", "/app/web/modules/custom/blog/templates/score.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 38, "if" => 39);
        static $filters = array("escape" => 40);
        static $functions = array("range" => 38);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape'],
                ['range']
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

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

/* modules/contrib/fivestar/templates/fivestar-summary.html.twig */
class __TwigTemplate_653a909821162601aaa445bde0f9d791 extends Template
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
        // line 42
        $context["classes"] = [0 => "fivestar-summary", 1 => ("fivestar-summary-" . $this->sandbox->ensureToStringAllowed(($context["output_type"] ?? null), 42, $this->source))];
        // line 43
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 43), 43, $this->source), "html", null, true);
        echo ">
  ";
        // line 44
        if (($context["user_rating"] ?? null)) {
            // line 45
            echo "    <span class=\"user-rating\">
      ";
            // line 46
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Your rating:"));
            echo " <span>";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_stars"] ?? null), 46, $this->source), "html", null, true);
            echo "</span>
    </span>
  ";
        }
        // line 49
        echo "
  ";
        // line 50
        if (($context["average_rating"] ?? null)) {
            // line 51
            echo "    <span class=\"average-rating\">
      ";
            // line 52
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Average:"));
            echo " <span";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["average_rating_microdata"] ?? null), 52, $this->source), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["average_stars"] ?? null), 52, $this->source), "html", null, true);
            echo "</span>
    </span>
  ";
        }
        // line 55
        echo "
  ";
        // line 56
        if ( !twig_test_empty(($context["votes"] ?? null))) {
            // line 57
            echo "    ";
            if ((($context["votes"] ?? null) == 0)) {
                // line 58
                echo "      <span class=\"empty\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("No votes yet"));
                echo "</span>
    ";
            } else {
                // line 60
                echo "      <span class=\"total-votes\">
        ";
                // line 61
                $context["votes_suffix"] = (((($context["votes"] ?? null) > 1)) ? (t("votes")) : (t("vote")));
                // line 62
                echo "        ";
                if ((($context["user_rating"] ?? null) || ($context["average_rating"] ?? null))) {
                    // line 63
                    echo "          (<span";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rating_count_microdata"] ?? null), 63, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["votes"] ?? null), 63, $this->source), "html", null, true);
                    echo "</span> ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["votes_suffix"] ?? null), 63, $this->source), "html", null, true);
                    echo ")
        ";
                } else {
                    // line 65
                    echo "          <span";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rating_count_microdata"] ?? null), 65, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["votes"] ?? null), 65, $this->source), "html", null, true);
                    echo "</span> ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["votes_suffix"] ?? null), 65, $this->source), "html", null, true);
                    echo "
        ";
                }
                // line 67
                echo "      </span>
    ";
            }
            // line 69
            echo "  ";
        }
        // line 70
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/fivestar/templates/fivestar-summary.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 70,  123 => 69,  119 => 67,  109 => 65,  99 => 63,  96 => 62,  94 => 61,  91 => 60,  85 => 58,  82 => 57,  80 => 56,  77 => 55,  67 => 52,  64 => 51,  62 => 50,  59 => 49,  51 => 46,  48 => 45,  46 => 44,  41 => 43,  39 => 42,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Default theme implementation for the Fivestar summary output.
 *
 * Note that passing in explicit data types is extremely important for the next
 * variables in this template:
 *   - average_rating
 *   - user_rating
 *   - votes
 * A NULL value will exclude the value entirely from display, while a 0 value
 * indicates that the text should be shown but it has no value yet.
 *
 * Available variables
 * - average_rating: The desired average rating to display out of 100 (i.e. 80
 *    is 4 out of 5 stars), or NULL for not to show average rating.
 *    Defaults to NULL.
 * - votes: The total number of votes.
 * - stars: The number of stars being displayed.
 * - microdata: An additional data to show rating in the search engines
 *   results.
 * - user_rating: The rating set by the user on the enclosing entity as an
 *   integer 1..100, or NULL for not to show user rating. Defaults to NULL.
 * - average_rating_microdata: An additional data to show average rating
 *   in the search engines results.
 * - rating_count_microdata: An additional data to show the number of votes in
 *   the search engines results.
 * - average_stars: rounded rating to display (example: 4.0)
 * - output_type: a word indicating the desired output style. One of:
 *     - \"user\" when display user rating.
 *     - \"user-count\" when display votes number and user rating.
 *     - \"average\" when display average rating.
 *     - \"average-count\" when display votes number and average rating.
 *     - \"combo\" when display user and average rating.
 *     - \"count\" when display the number of the votes.
 *
 * @see template_preprocess_fivestar_summary()
 *
 * @ingroup themeable
 */
#}
{% set classes = ['fivestar-summary', 'fivestar-summary-' ~ output_type] %}
<div{{ attributes.addClass(classes) }}>
  {% if user_rating %}
    <span class=\"user-rating\">
      {{ 'Your rating:'|t }} <span>{{ user_stars }}</span>
    </span>
  {% endif %}

  {% if average_rating %}
    <span class=\"average-rating\">
      {{ 'Average:'|t }} <span{{ average_rating_microdata }}>{{ average_stars }}</span>
    </span>
  {% endif %}

  {% if votes is not empty %}
    {% if votes == 0 %}
      <span class=\"empty\">{{ 'No votes yet'|t }}</span>
    {% else %}
      <span class=\"total-votes\">
        {% set votes_suffix = votes > 1 ? 'votes'|t : 'vote'|t %}
        {% if user_rating or average_rating %}
          (<span{{ rating_count_microdata }}>{{ votes }}</span> {{ votes_suffix }})
        {% else %}
          <span{{ rating_count_microdata }}>{{ votes }}</span> {{ votes_suffix }}
        {% endif %}
      </span>
    {% endif %}
  {% endif %}
</div>
", "modules/contrib/fivestar/templates/fivestar-summary.html.twig", "/app/web/modules/contrib/fivestar/templates/fivestar-summary.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 42, "if" => 44);
        static $filters = array("escape" => 43, "t" => 46);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape', 't'],
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

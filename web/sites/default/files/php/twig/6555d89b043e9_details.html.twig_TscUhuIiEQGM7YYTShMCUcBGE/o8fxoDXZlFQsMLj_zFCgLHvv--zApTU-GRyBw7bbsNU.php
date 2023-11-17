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

/* core/themes/claro/templates/details.html.twig */
class __TwigTemplate_fb9df52ea8b9c1fdf5e56459ddd5f9ae extends Template
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
        // line 28
        $context["classes"] = [0 => "claro-details", 1 => ((        // line 30
($context["accordion"] ?? null)) ? ("claro-details--accordion") : ("")), 2 => ((        // line 31
($context["accordion_item"] ?? null)) ? ("claro-details--accordion-item") : ("")), 3 => (((($__internal_compile_0 =         // line 32
($context["element"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["#module_package_listing"] ?? null) : null)) ? ("claro-details--package-listing") : (""))];
        // line 36
        $context["content_wrapper_classes"] = [0 => "claro-details__wrapper", 1 => "details-wrapper", 2 => ((        // line 39
($context["accordion"] ?? null)) ? ("claro-details__wrapper--accordion") : ("")), 3 => ((        // line 40
($context["accordion_item"] ?? null)) ? ("claro-details__wrapper--accordion-item") : ("")), 4 => (((($__internal_compile_1 =         // line 41
($context["element"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["#module_package_listing"] ?? null) : null)) ? ("claro-details__wrapper--package-listing") : (""))];
        // line 45
        $context["inner_wrapper_classes"] = [0 => "claro-details__content", 1 => ((        // line 47
($context["accordion"] ?? null)) ? ("claro-details__content--accordion") : ("")), 2 => ((        // line 48
($context["accordion_item"] ?? null)) ? ("claro-details__content--accordion-item") : ("")), 3 => (((($__internal_compile_2 =         // line 49
($context["element"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["#module_package_listing"] ?? null) : null)) ? ("claro-details__content--package-listing") : (""))];
        // line 52
        echo "<details";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 52), 52, $this->source), "html", null, true);
        echo ">";
        // line 53
        if (($context["title"] ?? null)) {
            // line 55
            $context["summary_classes"] = [0 => "claro-details__summary", 1 => ((            // line 57
($context["required"] ?? null)) ? ("js-form-required") : ("")), 2 => ((            // line 58
($context["required"] ?? null)) ? ("form-required") : ("")), 3 => ((            // line 59
($context["accordion"] ?? null)) ? ("claro-details__summary--accordion") : ("")), 4 => ((            // line 60
($context["accordion_item"] ?? null)) ? ("claro-details__summary--accordion-item") : ("")), 5 => (((($__internal_compile_3 =             // line 61
($context["element"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["#module_package_listing"] ?? null) : null)) ? ("claro-details__summary--package-listing") : (""))];
            // line 65
            echo "    <summary";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["summary_attributes"] ?? null), "addClass", [0 => ($context["summary_classes"] ?? null)], "method", false, false, true, 65), 65, $this->source), "html", null, true);
            echo ">";
            // line 66
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 66, $this->source), "html", null, true);
            // line 67
            if (($context["required"] ?? null)) {
                // line 68
                echo "<span class=\"required-mark\"></span>";
            }
            // line 70
            echo "</summary>";
        }
        // line 72
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => ($context["content_wrapper_classes"] ?? null)], "method", false, false, true, 72), 72, $this->source), "html", null, true);
        echo ">
    ";
        // line 73
        if ((($context["accordion"] ?? null) || ($context["accordion_item"] ?? null))) {
            // line 74
            echo "    <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["class" => ($context["inner_wrapper_classes"] ?? null)]), "html", null, true);
            echo ">
    ";
        }
        // line 76
        echo "
      ";
        // line 77
        if (($context["errors"] ?? null)) {
            // line 78
            echo "        <div class=\"form-item form-item--error-message\">
          ";
            // line 79
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["errors"] ?? null), 79, $this->source), "html", null, true);
            echo "
        </div>
      ";
        }
        // line 82
        if (($context["description"] ?? null)) {
            // line 83
            echo "<div class=\"claro-details__description";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(((($context["disabled"] ?? null)) ? (" is-disabled") : ("")));
            echo "\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 83, $this->source), "html", null, true);
            echo "</div>";
        }
        // line 85
        if (($context["children"] ?? null)) {
            // line 86
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["children"] ?? null), 86, $this->source), "html", null, true);
        }
        // line 88
        if (($context["value"] ?? null)) {
            // line 89
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["value"] ?? null), 89, $this->source), "html", null, true);
        }
        // line 92
        if ((($context["accordion"] ?? null) || ($context["accordion_item"] ?? null))) {
            // line 93
            echo "    </div>
    ";
        }
        // line 95
        echo "  </div>
</details>
";
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/details.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 95,  129 => 93,  127 => 92,  124 => 89,  122 => 88,  119 => 86,  117 => 85,  110 => 83,  108 => 82,  102 => 79,  99 => 78,  97 => 77,  94 => 76,  88 => 74,  86 => 73,  81 => 72,  78 => 70,  75 => 68,  73 => 67,  71 => 66,  67 => 65,  65 => 61,  64 => 60,  63 => 59,  62 => 58,  61 => 57,  60 => 55,  58 => 53,  54 => 52,  52 => 49,  51 => 48,  50 => 47,  49 => 45,  47 => 41,  46 => 40,  45 => 39,  44 => 36,  42 => 32,  41 => 31,  40 => 30,  39 => 28,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Theme override for a details element.
 *
 * Available variables
 * - attributes: A list of HTML attributes for the details element.
 * - errors: (optional) Any errors for this details element, may not be set.
 * - title: (optional) The title of the element, may not be set.
 * - description: (optional) The description of the element, may not be set.
 * - children: (optional) The children of the element, may not be set.
 * - value: (optional) The value of the element, may not be set.
 * - accordion: whether the details element should look as an accordion.
 * - accordion_item: whether the details element is an item of an accordion
 *   list.
 * - disabled: whether the details is disabled.
 *
 * @see template_preprocess_details()
 * @see claro_preprocess_details()
 */
#}
{#
  Prefix 'details' class to avoid collision with Modernizr.

  @todo Remove prefix after https://www.drupal.org/node/2981732 has been solved.
#}
{%
  set classes = [
    'claro-details',
    accordion ? 'claro-details--accordion',
    accordion_item ? 'claro-details--accordion-item',
    element['#module_package_listing'] ? 'claro-details--package-listing',
  ]
%}
{%
  set content_wrapper_classes = [
    'claro-details__wrapper',
    'details-wrapper',
    accordion ? 'claro-details__wrapper--accordion',
    accordion_item ? 'claro-details__wrapper--accordion-item',
    element['#module_package_listing'] ? 'claro-details__wrapper--package-listing',
  ]
%}
{%
  set inner_wrapper_classes = [
    'claro-details__content',
    accordion ? 'claro-details__content--accordion',
    accordion_item ? 'claro-details__content--accordion-item',
    element['#module_package_listing']  ? 'claro-details__content--package-listing',
  ]
%}
<details{{ attributes.addClass(classes) }}>
  {%- if title -%}
    {%
      set summary_classes = [
        'claro-details__summary',
        required ? 'js-form-required',
        required ? 'form-required',
        accordion ? 'claro-details__summary--accordion',
        accordion_item ? 'claro-details__summary--accordion-item',
        element['#module_package_listing']  ? 'claro-details__summary--package-listing',

    ]
    %}
    <summary{{ summary_attributes.addClass(summary_classes) }}>
      {{- title -}}
      {%- if required -%}
        <span class=\"required-mark\"></span>
      {%- endif -%}
    </summary>
  {%- endif -%}
  <div{{ content_attributes.addClass(content_wrapper_classes) }}>
    {% if accordion or accordion_item %}
    <div{{ create_attribute({class: inner_wrapper_classes}) }}>
    {% endif %}

      {% if errors %}
        <div class=\"form-item form-item--error-message\">
          {{ errors }}
        </div>
      {% endif %}
      {%- if description -%}
        <div class=\"claro-details__description{{ disabled ? ' is-disabled' }}\">{{ description }}</div>
      {%- endif -%}
      {%- if children -%}
        {{ children }}
      {%- endif -%}
      {%- if value -%}
        {{ value }}
      {%- endif -%}

    {% if accordion or accordion_item %}
    </div>
    {% endif %}
  </div>
</details>
", "core/themes/claro/templates/details.html.twig", "/app/web/core/themes/claro/templates/details.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 28, "if" => 53);
        static $filters = array("escape" => 52);
        static $functions = array("create_attribute" => 74);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape'],
                ['create_attribute']
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

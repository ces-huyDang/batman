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

/* core/themes/claro/templates/admin/admin-block-content.html.twig */
class __TwigTemplate_f6f9d6123faffa6e5aced32d351e1c87 extends Template
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
        // line 21
        $context["item_classes"] = [0 => "admin-item"];
        // line 25
        if (($context["content"] ?? null)) {
            // line 26
            echo "  <dl";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "admin-list"], "method", false, false, true, 26), 26, $this->source), "html", null, true);
            echo ">
    ";
            // line 27
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["content"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 28
                echo "      <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->createAttribute(["class" => ($context["item_classes"] ?? null)]), "html", null, true);
                echo ">
        <dt class=\"admin-item__title\">";
                // line 29
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 29), 29, $this->source), "html", null, true);
                echo "</dt>
        ";
                // line 30
                if (twig_get_attribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, true, 30)) {
                    // line 31
                    echo "          <dd class=\"admin-item__description\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, true, 31), 31, $this->source), "html", null, true);
                    echo "</dd>
        ";
                }
                // line 33
                echo "      </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 35
            echo "  </dl>
";
        }
    }

    public function getTemplateName()
    {
        return "core/themes/claro/templates/admin/admin-block-content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 35,  69 => 33,  63 => 31,  61 => 30,  57 => 29,  52 => 28,  48 => 27,  43 => 26,  41 => 25,  39 => 21,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Claro's theme implementation for the content of an administrative block.
 *
 * Available variables:
 * - content: List of administrative menu items. Each menu item contains:
 *   - link: Link to the admin section.
 *   - title: Short name of the section.
 *   - description: Description of the administrative menu item.
 *   - url: URI to the admin section.
 *   - options: URL options. See \\Drupal\\Core\\Url::fromUri() for details.
 * - attributes: HTML attributes to be added to the element.
 * - compact: Boolean indicating whether compact mode is turned on or not.
 *
 * @see template_preprocess_admin_block_content()
 * @see claro_preprocess_admin_block_content()
 */
#}
{%
  set item_classes = [
    'admin-item',
  ]
%}
{% if content %}
  <dl{{ attributes.addClass('admin-list') }}>
    {% for item in content %}
      <div{{ create_attribute({class: item_classes}) }}>
        <dt class=\"admin-item__title\">{{ item.link }}</dt>
        {% if item.description %}
          <dd class=\"admin-item__description\">{{ item.description }}</dd>
        {% endif %}
      </div>
    {% endfor %}
  </dl>
{% endif %}
", "core/themes/claro/templates/admin/admin-block-content.html.twig", "/app/web/core/themes/claro/templates/admin/admin-block-content.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 21, "if" => 25, "for" => 27);
        static $filters = array("escape" => 26);
        static $functions = array("create_attribute" => 28);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'for'],
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

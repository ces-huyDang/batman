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

/* modules/custom/blog/templates/index.html.twig */
class __TwigTemplate_91b65b9a9b5ac4973d7b03c75aa04686 extends Template
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
    ";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_sort_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "posts", [], "any", false, false, true, 3), function ($__a__, $__b__) use ($context, $macros) { $context["a"] = $__a__; $context["b"] = $__b__; return ((($__internal_compile_0 = ($context["b"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["is_featured"] ?? null) : null) <=> (($__internal_compile_1 = ($context["a"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["is_featured"] ?? null) : null)); }));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 4
            echo "      <div class=";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(((((($__internal_compile_2 = $context["post"]) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["is_featured"] ?? null) : null) === true)) ? ("col-12") : ("col-6")));
            echo ">
        <div id=";
            // line 5
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("post" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 5), 5, $this->source)), "html", null, true);
            echo " class=\"card mb-4 posts\">
          <img src=";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((((($__internal_compile_3 = $context["post"]) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["is_featured"] ?? null) : null) === true)) ? (Drupal\twig_tweak\TwigTweakExtension::imageStyleFilter($this->sandbox->ensureToStringAllowed((($__internal_compile_4 = (($__internal_compile_5 = $context["post"]) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5["thumbnail_uri"] ?? null) : null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4[0] ?? null) : null), 6, $this->source), "featured_post_thumbnail")) : (Drupal\twig_tweak\TwigTweakExtension::imageStyleFilter($this->sandbox->ensureToStringAllowed((($__internal_compile_6 = (($__internal_compile_7 = $context["post"]) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7["thumbnail_uri"] ?? null) : null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6[0] ?? null) : null), 6, $this->source), "post_thumbnail"))), "html", null, true);
            echo " class=\"card-img-top thumbnail\" alt=\"...\">
          <div class=\"card-body\">
            <div class=\"text-muted author\">
              Created on
              ";
            // line 10
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_date_format_filter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_8 = $context["post"]) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8["created"] ?? null) : null), 10, $this->source), "j F, Y"), "html", null, true);
            echo "
              by
              <a class=\"link\" href=";
            // line 12
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("user/" . $this->sandbox->ensureToStringAllowed((($__internal_compile_9 = $context["post"]) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9["uid"] ?? null) : null), 12, $this->source)), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_10 = $context["post"]) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10["user_name"] ?? null) : null), 12, $this->source), "html", null, true);
            echo "</a>
            </div>
            <span>
              <b class=\"card-title fs-3\">";
            // line 15
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_11 = $context["post"]) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11["title"] ?? null) : null), 15, $this->source), "html", null, true);
            echo "</b>
            </span>
            <p id=";
            // line 17
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("card-text" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 17), 17, $this->source)), "html", null, true);
            echo " class=\"card-text\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (((twig_get_attribute($this->env, $this->source, (($__internal_compile_12 = $context["post"]) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12["body"] ?? null) : null), "length", [], "any", false, false, true, 17) > 200)) ? (twig_striptags($this->sandbox->ensureToStringAllowed((($__internal_compile_13 = $context["post"]) && is_array($__internal_compile_13) || $__internal_compile_13 instanceof ArrayAccess ? ($__internal_compile_13["body"] ?? null) : null), 17, $this->source))) : ((twig_slice($this->env, twig_striptags($this->sandbox->ensureToStringAllowed((($__internal_compile_14 = $context["post"]) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14["body"] ?? null) : null), 17, $this->source)), 0, 197) . "..."))), "html", null, true);
            echo "</p>
            <a id=";
            // line 18
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("btn" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 18), 18, $this->source)), "html", null, true);
            echo " href=";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("node/" . $this->sandbox->ensureToStringAllowed((($__internal_compile_15 = $context["post"]) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15["id"] ?? null) : null), 18, $this->source)), "html", null, true);
            echo " class=\"btn btn-secondary\">Read more</a>
          </div>
        </div>
      </div>
    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/blog/templates/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 23,  100 => 18,  94 => 17,  89 => 15,  81 => 12,  76 => 10,  69 => 6,  65 => 5,  60 => 4,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"container-fluid\">
  <div class=\"row\">
    {% for post in data.posts|sort((a, b) => (b['is_featured'] <=> a['is_featured'])) %}
      <div class={{ post['is_featured'] is same as(true) ? \"col-12\" : \"col-6\" }}>
        <div id={{ \"post\" ~ loop.index0 }} class=\"card mb-4 posts\">
          <img src={{ post['is_featured'] is same as(true) ? post['thumbnail_uri'][0]|image_style('featured_post_thumbnail') : post['thumbnail_uri'][0]|image_style('post_thumbnail')}} class=\"card-img-top thumbnail\" alt=\"...\">
          <div class=\"card-body\">
            <div class=\"text-muted author\">
              Created on
              {{post['created']|date('j F, Y')}}
              by
              <a class=\"link\" href={{'user/' ~ post['uid']}}>{{post['user_name']}}</a>
            </div>
            <span>
              <b class=\"card-title fs-3\">{{post['title']}}</b>
            </span>
            <p id={{ \"card-text\" ~ loop.index0 }} class=\"card-text\">{{post['body'].length > 200 ? post['body']|striptags : post['body']|striptags|slice(0, 197) ~ '...' }}</p>
            <a id={{ \"btn\" ~ loop.index0 }} href={{'node/' ~ post['id'] }} class=\"btn btn-secondary\">Read more</a>
          </div>
        </div>
      </div>
    {% endfor %}
  </div>
</div>
", "modules/custom/blog/templates/index.html.twig", "/app/web/modules/custom/blog/templates/index.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 3);
        static $filters = array("sort" => 3, "escape" => 5, "image_style" => 6, "date" => 10, "striptags" => 17, "slice" => 17);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['sort', 'escape', 'image_style', 'date', 'striptags', 'slice'],
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

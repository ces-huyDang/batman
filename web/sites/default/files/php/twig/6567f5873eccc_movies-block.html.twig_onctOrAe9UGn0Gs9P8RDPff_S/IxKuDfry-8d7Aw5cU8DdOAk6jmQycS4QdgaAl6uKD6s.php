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

/* modules/custom/blog/templates/movies-block.html.twig */
class __TwigTemplate_4e6273fe97fbeeef91443f89afb8d8b6 extends Template
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
        echo "<div id=\"movies-block\" class=\"card w-75 d-none position-absolute z-3 mx-auto\">
  <div class=\"card-body\">
    <div class=\"row mt-2\">
      <div class=\"col-6 col-hr\">
        <h4 class=\"text-center text-white\">Best Movie Series</h4>
        <div class=\"card bg-dark\">
          <div class=\"card-body\">
            <div class=\"row\">
              ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "movies", [], "any", false, false, true, 9));
        foreach ($context['_seq'] as $context["_key"] => $context["movie"]) {
            // line 10
            echo "                <div class=\"col-4 text-center\">
                  <span class=\"text-white\">
                    ";
            // line 12
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_0 = $context["movie"]) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["title"] ?? null) : null), 12, $this->source), "html", null, true);
            echo "
                  </span>
                  <img class=\"border border-white\" src=";
            // line 14
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::imageStyleFilter($this->sandbox->ensureToStringAllowed((($__internal_compile_1 = (($__internal_compile_2 = $context["movie"]) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["thumbnail_uri"] ?? null) : null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[0] ?? null) : null), 14, $this->source), "small_thumbnail"), "html", null, true);
            echo ">
                </div>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['movie'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "            </div>
          </div>
        </div>
      </div>
      <div class=\"col-2 col-hr\">
        <div class=\"row\">
          <div class=\"col-12 text-center\">
            <h4 class=\"text-white\">Streaming</h4>
            ";
        // line 25
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "streaming_sites", [], "any", false, false, true, 25));
        foreach ($context['_seq'] as $context["_key"] => $context["site"]) {
            // line 26
            echo "              <div class=\"row chars-name\">
                <a href=";
            // line 27
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ("/taxonomy/term/" . $this->sandbox->ensureToStringAllowed((($__internal_compile_3 = $context["site"]) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["tid"] ?? null) : null), 27, $this->source)), "html", null, true);
            echo ">
                  ";
            // line 28
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_4 = $context["site"]) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4["term_name"] ?? null) : null), 28, $this->source), "html", null, true);
            echo "
                </a>
              </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['site'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "          </div>
        </div>
      </div>
      <div class=\"col-4\">
        <div class=\"row text-center\">
          <h4 class=\"text-white\">Top Movies</h4>
          <div class=\"row\">
            ";
        // line 39
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "scores", [], "any", false, false, true, 39));
        foreach ($context['_seq'] as $context["_key"] => $context["score"]) {
            // line 40
            echo "              <div class=\"col-6 position-relative\">
                <img class=\"border border-white\" src=";
            // line 41
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Drupal\twig_tweak\TwigTweakExtension::imageStyleFilter($this->sandbox->ensureToStringAllowed((($__internal_compile_5 = (($__internal_compile_6 = $context["score"]) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6["image_uri"] ?? null) : null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5[0] ?? null) : null), 41, $this->source), "small_thumbnail"), "html", null, true);
            echo ">
                  <div class=\"col-2 position-absolute top-0 start-68\">
                    <div class=\"square bg-success\">
                      ";
            // line 44
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_7 = $context["score"]) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7["score"] ?? null) : null), 44, $this->source), "html", null, true);
            echo "
                    </div>
                </div>
              </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['score'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/blog/templates/movies-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 49,  124 => 44,  118 => 41,  115 => 40,  111 => 39,  102 => 32,  92 => 28,  88 => 27,  85 => 26,  81 => 25,  71 => 17,  62 => 14,  57 => 12,  53 => 10,  49 => 9,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div id=\"movies-block\" class=\"card w-75 d-none position-absolute z-3 mx-auto\">
  <div class=\"card-body\">
    <div class=\"row mt-2\">
      <div class=\"col-6 col-hr\">
        <h4 class=\"text-center text-white\">Best Movie Series</h4>
        <div class=\"card bg-dark\">
          <div class=\"card-body\">
            <div class=\"row\">
              {% for movie in data.movies %}
                <div class=\"col-4 text-center\">
                  <span class=\"text-white\">
                    {{ movie['title'] }}
                  </span>
                  <img class=\"border border-white\" src={{ movie['thumbnail_uri'][0]|image_style('small_thumbnail') }}>
                </div>
              {% endfor %}
            </div>
          </div>
        </div>
      </div>
      <div class=\"col-2 col-hr\">
        <div class=\"row\">
          <div class=\"col-12 text-center\">
            <h4 class=\"text-white\">Streaming</h4>
            {% for site in data.streaming_sites %}
              <div class=\"row chars-name\">
                <a href={{ \"/taxonomy/term/\" ~ site['tid'] }}>
                  {{ site['term_name'] }}
                </a>
              </div>
            {% endfor %}
          </div>
        </div>
      </div>
      <div class=\"col-4\">
        <div class=\"row text-center\">
          <h4 class=\"text-white\">Top Movies</h4>
          <div class=\"row\">
            {% for score in data.scores %}
              <div class=\"col-6 position-relative\">
                <img class=\"border border-white\" src={{ score['image_uri'][0]|image_style('small_thumbnail') }}>
                  <div class=\"col-2 position-absolute top-0 start-68\">
                    <div class=\"square bg-success\">
                      {{ score['score'] }}
                    </div>
                </div>
              </div>
            {% endfor %}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
", "modules/custom/blog/templates/movies-block.html.twig", "/app/web/modules/custom/blog/templates/movies-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 9);
        static $filters = array("escape" => 12, "image_style" => 14);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['escape', 'image_style'],
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

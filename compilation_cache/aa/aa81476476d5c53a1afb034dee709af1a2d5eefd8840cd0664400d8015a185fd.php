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

/* sell.twig */
class __TwigTemplate_040a0a7537950f88c49792558aed72fae5993f41144eeb9527bb0c809d0e697d extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.twig", "sell.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "
";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["alerts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["alert"]) {
            // line 6
            echo "<div class=\"alert alert-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["alert"], "type", [], "any", false, false, false, 6), "html", null, true);
            echo " alert-dismissible fade show\" role=\"alert\">
  ";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["alert"], "message", [], "any", false, false, false, 7), "html", null, true);
            echo "
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['alert'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "
<main class=\"container p-5\">
  <form action=\"/sell";
        // line 15
        if ((($context["symbol"] ?? null) != "")) {
            echo "?symbol=";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
        }
        echo "\" method=\"POST\">
    <h1 class=\"display-4\">Sell</h1>
    <div class=\"form-group\">
        <select class=\"custom-select form-control\" name=\"symbol\" required>
            ";
        // line 19
        if ((($context["symbol"] ?? null) == "")) {
            echo "<option selected disabled value=\"\">Choose stock</option>";
        }
        // line 20
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stocks"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["stock"]) {
            // line 21
            echo "                ";
            if (($context["stock"] == ($context["symbol"] ?? null))) {
                // line 22
                echo "                  <option selected value=\"";
                echo twig_escape_filter($this->env, $context["stock"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $context["stock"], "html", null, true);
                echo "</option>
                ";
            } else {
                // line 24
                echo "                  <option value=\"";
                echo twig_escape_filter($this->env, $context["stock"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $context["stock"], "html", null, true);
                echo "</option>
                ";
            }
            // line 26
            echo "            ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 27
            echo "                <option disabled value=\"\">No stocks available to choose from</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stock'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "        </select>
    </div>
    <div class=\"form-group\">
        <input class=\"form-control\" name=\"shares\" placeholder=\"Number of shares\" type=\"number\" min=\"1\" required>
    </div>
      <button class=\"btn btn-primary\" type=\"submit\">Sell</button>
  </form>
</main>
";
    }

    public function getTemplateName()
    {
        return "sell.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 29,  122 => 27,  117 => 26,  109 => 24,  101 => 22,  98 => 21,  92 => 20,  88 => 19,  78 => 15,  74 => 13,  62 => 7,  57 => 6,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "sell.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\sell.twig");
    }
}

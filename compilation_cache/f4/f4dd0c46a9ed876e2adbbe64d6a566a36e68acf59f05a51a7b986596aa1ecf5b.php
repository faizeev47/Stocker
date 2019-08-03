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

/* buy.twig */
class __TwigTemplate_1a45fa238de7127e0a3199c566aa4c9cab13749156e70b3646a9de9873d3abd0 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("layout.twig", "buy.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["alerts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["alert"]) {
            // line 5
            echo "<div class=\"alert alert-";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["alert"], "type", [], "any", false, false, false, 5), "html", null, true);
            echo " alert-dismissible fade show\" role=\"alert\">
  ";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["alert"], "message", [], "any", false, false, false, 6), "html", null, true);
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
        // line 12
        echo "
<main class=\"container p-5\">
  <form action=\"/buy\" method=\"POST\">
      <h1 class=\"display-4\">Buy</h1>
      <div class=\"form-group\">
          ";
        // line 17
        if (twig_test_empty(($context["symbol"] ?? null))) {
            // line 18
            echo "            <input autofocus  autocomplete=\"off\" class=\"form-control\" name=\"symbol\" placeholder=\"Symbol\" type=\"text\" value=\"";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "\" required>
          ";
        } else {
            // line 20
            echo "            <input  autocomplete=\"off\" class=\"form-control\" name=\"symbol\" placeholder=\"Symbol\" type=\"text\" value=\"";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "\" required>
          ";
        }
        // line 22
        echo "      </div>
      <div class=\"form-group\">
        ";
        // line 24
        if (twig_test_empty(($context["symbol"] ?? null))) {
            // line 25
            echo "          <input  class=\"form-control\" name=\"shares\" placeholder=\"Number of shares\" type=\"number\" min=\"1\" required>
        ";
        } else {
            // line 27
            echo "          <input autofocus class=\"form-control\" name=\"shares\" placeholder=\"Number of shares\" type=\"number\" min=\"1\" required>
        ";
        }
        // line 29
        echo "
      </div>
      <button class=\"btn btn-primary\" type=\"submit\" id=\"submit-button\">Buy</button>
  </form>
</main>
";
    }

    public function getTemplateName()
    {
        return "buy.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 29,  102 => 27,  98 => 25,  96 => 24,  92 => 22,  86 => 20,  80 => 18,  78 => 17,  71 => 12,  59 => 6,  54 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "buy.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\buy.twig");
    }
}

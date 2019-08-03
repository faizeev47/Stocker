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

/* quote.twig */
class __TwigTemplate_6bc341078ea9d20985d0338eabd7412cf16b611f11ba4eccddf5542bc3a38d8d extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
            'scripts' => [$this, 'block_scripts'],
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
        $this->parent = $this->loadTemplate("layout.twig", "quote.twig", 1);
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
            echo "  <div class=\"alert alert-";
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
";
        // line 15
        if ((($context["quoted"] ?? null) == true)) {
            // line 16
            echo "  <label class=\"display-4 trade-font\">";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "</label>
  <hr>
  <label class=\"display-4\">";
            // line 18
            echo twig_escape_filter($this->env, ($context["company"] ?? null), "html", null, true);
            echo "</label>
  <hr>
  <label class=\"display-4 cash-text\">\$";
            // line 20
            echo twig_escape_filter($this->env, ($context["price"] ?? null), "html", null, true);
            echo "</label><br><span class=\"badge badge-pill badge-success\">Live</span>
  <hr>
  <a class=\"btn btn-primary\" href=\"/buy?symbol=";
            // line 22
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "\">Buy this stock</a>
  <a class=\"btn btn-primary\" href=\"/detailedQuote?symbol=";
            // line 23
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "\">Get detailed quote<span class=\"badge badge-pill badge-success\">Live</span></a>
  <hr>
";
        }
        // line 26
        echo "  <form action=\"/quote?symbol=\" method=\"GET\">

    <h1 class=\"display-4\">";
        // line 28
        if ((($context["quoted"] ?? null) == true)) {
            echo "Lookup another symbol";
        } else {
            echo "Quote";
        }
        echo "</h1>
    <div class=\"form-group\">
      <input class=\"form-control\" type=\"text\" name=\"symbol\" placeholder=\"Symbol\" required>
    </div>
    <button class=\"btn btn-primary\" type=\"submit\" id=\"submit-button\">Lookup</button>
  </form>
</main>

";
    }

    // line 38
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 39
        echo "<script type=\"text/javascript\">
\$('.badge').each(function(index, element){
  tippy(element,{
    content: 'Live content from IEX API',
    animation: 'fade',
    arrow: true,
    arrowType: 'sharp',
    delay: [10,10]
  });
});
</script>
";
    }

    public function getTemplateName()
    {
        return "quote.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 39,  128 => 38,  111 => 28,  107 => 26,  101 => 23,  97 => 22,  92 => 20,  87 => 18,  81 => 16,  79 => 15,  75 => 13,  63 => 7,  58 => 6,  54 => 5,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "quote.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\quote.twig");
    }
}

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

/* history.twig */
class __TwigTemplate_6c973d509b086d9d64faf84f0a23b5bba4bdf4c1485f873b83508d386ddff706 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("layout.twig", "history.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "  <main class=\"container p-5\">
    <label class=\"display-4\">History</label>
    <hr>
    <table class=\"table table-responsive-sm\" id=\"table\">
        <thead>
            <tr>
                <th scope=\"col\">Transaction ID</th>
                <th scope=\"col\">Stock</th>
                <th scope=\"col\">Shares transacted</th>
                <th scope=\"col\">Transaction price</th>
                <th scope=\"col\">Date</th>
                <th scope=\"col\">Time</th>
                <th scope=\"col\">Transaction type</th>
            </tr>
        </thead>
        <tbody>
          ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["history"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["record"]) {
            // line 20
            echo "            <tr>
              <td>";
            // line 21
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "trans_id", [], "any", false, false, false, 21), "html", null, true);
            echo "</td>
              <td class=\"trade-font\">";
            // line 22
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "symbol", [], "any", false, false, false, 22), "html", null, true);
            echo "</td>
              <td>";
            // line 23
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "shares", [], "any", false, false, false, 23), "html", null, true);
            echo "</td>
              <td class=\"cash-text\">\$";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "price", [], "any", false, false, false, 24), "html", null, true);
            echo "</td>
              <td>";
            // line 25
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "date", [], "any", false, false, false, 25), "html", null, true);
            echo "</td>
              <td>";
            // line 26
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "time", [], "any", false, false, false, 26), "html", null, true);
            echo "</td>
              <td>";
            // line 27
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["record"], "type", [], "any", false, false, false, 27), "html", null, true);
            echo "</td>
            </tr>
          ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 30
            echo "            <tr>
              <td colspan=\"7\"><div class=\"lead\">Buy or sell some stocks to display your transaction history here!</div></td>
            </tr>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['record'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "        </tbody>
    </table>
  </main>
";
    }

    // line 40
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 41
        echo "<script type=\"text/javascript\">
  \$(document).ready(function() {
    \$('#table').DataTable();
  } );
</script>
";
    }

    public function getTemplateName()
    {
        return "history.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 41,  125 => 40,  118 => 34,  109 => 30,  101 => 27,  97 => 26,  93 => 25,  89 => 24,  85 => 23,  81 => 22,  77 => 21,  74 => 20,  69 => 19,  51 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "history.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\history.twig");
    }
}

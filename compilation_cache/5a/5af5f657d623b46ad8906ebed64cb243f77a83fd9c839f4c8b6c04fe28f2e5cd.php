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

/* home.twig */
class __TwigTemplate_de3cb3b44354b40dd5b7b4ea3730c0ce5779918bb82e313fb18d23fb4c31569b extends \Twig\Template
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
        $this->parent = $this->loadTemplate("layout.twig", "home.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "
";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["alerts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["alert"]) {
            // line 5
            echo "  <div class=\"alert alert-";
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
  <label class=\"display-2\">Dashboard</label>
  <br>
  <label class=\"display-4\">Portfolio</label>
  <hr>
  <div class=\"container-fluid\">
    <table class=\"table table-responsive-sm table-hover\">
      ";
        // line 20
        if ((($context["api_error"] ?? null) == true)) {
            // line 21
            echo "      <thead>
          <tr>
              <th scope=\"col\">Symbol</th>
              <th scope=\"col\">Shares</th>
          </tr>
      </thead>
      <tbody>
        ";
            // line 28
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["stocks"] ?? null));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["stock"]) {
                // line 29
                echo "        <tr>
            <td class=\"trade-font\">";
                // line 30
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "symbol", [], "any", false, false, false, 30), "html", null, true);
                echo "</td>
            <td>";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "shares", [], "any", false, false, false, 31), "html", null, true);
                echo "</td>

        </tr>
        ";
                $context['_iterated'] = true;
            }
            if (!$context['_iterated']) {
                // line 35
                echo "        <tr>
          <td colspan=\"2\"><a href=\"/buy\"><div class=\"lead\">Buy some stocks to display them here</div></a></td>
        </tr>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stock'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 39
            echo "        <tr>
          <td style=\"font-size:18px;\"><strong>User</strong></td>
          <td class=\"cash-text\" style=\"font-size:18px;\"><strong>\$";
            // line 41
            echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
            echo "</strong></td>
        </tr>
        <tr>
          <td style=\"font-size:18px;\"><strong>Total</strong></td>
          <td class=\"cash-text\" style=\"font-size:18px;\"><strong>\$";
            // line 45
            echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
            echo "</strong></td>
        </tr>
      </tbody>
      ";
        } else {
            // line 49
            echo "      <thead>
          <tr>
              <th scope=\"col\">Symbol</th>
              <th scope=\"col\">Name</th>
              <th scope=\"col\">Shares</th>
              <th scope=\"col\">Change <span class=\"badge badge-pill badge-success\">Live</span></th>
              <th scope=\"col\">Latest Price <span class=\"badge badge-pill badge-success\">Live</span></th>
              <th scope=\"col\">TOTAL</th>
          </tr>
      </thead>
      <tbody>
        ";
            // line 60
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["stocks"] ?? null));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["stock"]) {
                // line 61
                echo "        <tr class=\"stock-links pointer tippy table-rows\" data-tippy-content=\"Click to go to ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "name", [], "any", false, false, false, 61), "html", null, true);
                echo " stock\">
          <td id=\"symbol\" class=\"trade-font\">";
                // line 62
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "symbol", [], "any", false, false, false, 62), "html", null, true);
                echo "</td>
          <td>";
                // line 63
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "name", [], "any", false, false, false, 63), "html", null, true);
                echo "</td>
          <td>";
                // line 64
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "shares", [], "any", false, false, false, 64), "html", null, true);
                echo "</td>
          <td class=\"cash-text change\" value=\"";
                // line 65
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "change", [], "any", false, false, false, 65), "html", null, true);
                echo "\">
            (<span class=\"cash-text changePercent\" value=\"";
                // line 66
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "changePercent", [], "any", false, false, false, 66), "html", null, true);
                echo "\"></span>)
          </td>
          <td class=\"cash-text\">\$";
                // line 68
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "latestPrice", [], "any", false, false, false, 68), "html", null, true);
                echo "</td>
          <td class=\"cash-text\">\$";
                // line 69
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stock"], "total", [], "any", false, false, false, 69), "html", null, true);
                echo "</td>
        </tr>

        ";
                $context['_iterated'] = true;
            }
            if (!$context['_iterated']) {
                // line 73
                echo "        <tr>
          <td colspan=\"7\"><a href=\"/buy\"><div class=\"lead\">Buy some stocks to display them here</div></a></td>
        </tr>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stock'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 77
            echo "        <tr>
          <td style=\"font-size:18px;\"><strong>User</strong></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class=\"cash-text\" style=\"font-size:18px;\">\$";
            // line 83
            echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
            echo "</td>
        </tr>
        <tr>
          <td style=\"font-size:18px;\"><strong>Total</strong></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class=\"cash-text\" style=\"font-size:18px;\">\$";
            // line 91
            echo twig_escape_filter($this->env, ($context["total"] ?? null), "html", null, true);
            echo "</td>
        </tr>
      </tbody>

      ";
        }
        // line 96
        echo "    </table>
  </div>

  <section id=\"mostactive-section\">

  </section>

  <section id=\"gainers-section\">

  </section>

  <section id=\"iexvolume-section\">

  </section>

  <section id=\"iexpercent-section\">

  </section>

  <section id=\"losers-section\">

  </section>

</main>
";
    }

    // line 122
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 123
        echo "<script type=\"text/javascript\">
  \$(document).ready(function(){
    \$('.changePercent').each(function(index, element){
      let c = parseFloat(\$(element).attr('value'));
      if (c) {
        if (c > 0) {
          \$(element).css('color',\"#27ae60\");
        }
        else{
          \$(element).css('color',\"red\");
        }
        \$(element).html(formatChange(c,\"percent\"));
      }
    });
    \$('.change').each(function(index, element){
      let c = parseFloat(\$(element).attr('value'));
      let img;
      if (c > 0) {
        \$(element).css('color',\"#27ae60\");
      }
      else if (c < 0){
        \$(element).css('color',\"red\");
      }
      \$(element).prepend(formatChange(c,\"cash\"));
    });


    \$('.stock-links').click(function(){
      window.location = \"detailedQuote?symbol=\" + \$(this).find('#symbol').text();
    });

    var headings = ['Most Active', 'Gainers', 'Losers', 'IEX Volume', 'IEX Percent'];
    var traders = ['mostactive', 'gainers', 'losers','iexvolume','iexpercent'];

    \$(traders).each(function(index,element){
      var url = \"";
        // line 158
        echo twig_escape_filter($this->env, ($context["b"] ?? null), "html", null, true);
        echo "/stock/market/list/\"+element+\"?";
        echo twig_escape_filter($this->env, ($context["t"] ?? null), "html", null, true);
        echo "&displayPercent=true\";
      \$.getJSON(url, function(list) {
        console.log(element);
        console.log(list);
        makeStockSection(headings[index], element);
        if(!list || list.length == 0){
          let card = makeStockCard('N/A','No Stocks found in list', 0, 0, 0, 0, false);
          \$('.'+element+'-stocks').append(card);
        }
        var count = Object.keys(list).length;
        for (var i = 0; i < count; i++){
          var card = makeStockCard(list[i]['symbol'],
               list[i].companyName, list[i].latestPrice,
               list[i].close,list[i].open,
               list[i].changePercent, list[i].change,
               list[i].latestVolume, list[i].volume,
               list[i].avgTotalVolume,  true);
           tippy(card,{
             content: \"Click to go to \" + list[i].companyName + \" stock\",
             animation: 'fade',
             arrow: true,
             arrowType: 'round',
             delay: [500,5],
             followCursor: true,
           });
          \$('.'+element+'-stocks').append(card);
        }
      });
    });

    \$('.badge').each(function(index, element){
      tippy(element,{
        content: 'Live content from IEX API',
        animation: 'fade',
        arrow: true,
        arrowType: 'sharp',
        delay: [10,10]
      });
    });
    \$('.tippy').each(function(index, element){
      tippy(element,{
        content: \$(element).attr('data-tippy-content'),
        animation: 'fade',
        arrow: true,
        arrowType: 'round',
        delay: [300,10],
        followCursor: 'horizontal',
      });
    });
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  306 => 158,  269 => 123,  265 => 122,  237 => 96,  229 => 91,  218 => 83,  210 => 77,  201 => 73,  192 => 69,  188 => 68,  183 => 66,  179 => 65,  175 => 64,  171 => 63,  167 => 62,  162 => 61,  157 => 60,  144 => 49,  137 => 45,  130 => 41,  126 => 39,  117 => 35,  108 => 31,  104 => 30,  101 => 29,  96 => 28,  87 => 21,  85 => 20,  75 => 12,  63 => 6,  58 => 5,  54 => 4,  51 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\home.twig");
    }
}

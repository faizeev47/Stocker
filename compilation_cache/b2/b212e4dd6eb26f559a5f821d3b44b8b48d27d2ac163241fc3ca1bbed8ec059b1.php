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

/* detailedQuote.twig */
class __TwigTemplate_330d524e46b6df062cf818196dc82c70c1f1d7603e591bc979c4873f2f7b8ef3 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("layout.twig", "detailedQuote.twig", 1);
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
";
        // line 14
        if (($context["quoted"] ?? null)) {
            // line 15
            echo "<main class=\"container-fluid p-5\" style=\"text-align:left;\">
  <div class=\"row\">
    <div class=\"col-lg\">
      <div class=\"row\">
        <div class=\"col\">
          <form action=\"/detailedQuote?symbol=\" method=\"GET\">
            <input class=\"form-control\" style=\"width:75%\" type=\"text\" name=\"symbol\" placeholder=\"Symbol\" required>
            <button class=\"btn btn-primary\" type=\"submit\" id=\"submit-button\">Lookup</button>
          </form>
        </div>
      </div>
      <hr>
      <h1 class=\"display-4 trade-font\" style=\"text-align:center\">";
            // line 27
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "</h1>
      <hr>
      <img id=\"logo\" class=\"img-fluid float-right\" src=\"https://storage.googleapis.com/iex/api/logos/";
            // line 29
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo ".png\">
      <div class=\"display-4 company-attribute\" id=\"companyName\"></div>
      <div class=\"subtitle company-attribute\" id=\"sector\"></div>
      <hr style=\"margin-top:80px\">
      <h1 class=\"sub-heading lead\">Profile</h1>
      <p class=\"company-attribute\" id=\"description\"></p>
      <hr>
      <div class=\"row\">
        <div class=\"col\">
          <b class=\"sub-heading lead\">CEO</b> <hr>
          <div class=\"company-attribute\" id=\"CEO\"></div>
        </div>
        <div class=\"col\">
          <b class=\"sub-heading lead\">Website</b><hr>
          <a class=\"company-attribute\" id=\"website\"></a>
        </div>
        <div class=\"col\">
          <b class=\"sub-heading lead\">Industry</b> <hr>
          <div class=\"company-attribute\" id=\"industry\"></div>
        </div>
        <div class=\"col\">
          <b class=\"sub-heading lead\">Exchange</b> <hr>
          <div class=\"company-attribute\" id=\"exchange\"></div>
        </div>
      </div>
      <hr>
      <div class=\"row\">
        <div class=\"col\">
          <div id=\"tags\"></div>
        </div>
      </div>
      <hr>
      <b class=\"sub-heading lead\">Related</b> <br>
      <div id=\"peers\" class=\"row\">

      </div>
      <hr>
      <div class=\"row\">
        <div class=\"col\">
          <b class=\"sub-heading display-4\">News</b> <br>
          <div class=\"container-fluid\" id=\"news-container\">
            <div id=\"carouselCaptions\" class=\"carousel slide\" data-ride=\"carousel\">
              <ol id=\"carousel-indicators\" class=\"carousel-indicators\"></ol>
              <div id=\"carousel-inner\" class=\"carousel-inner\"></div>
              <a class=\"carousel-control-prev\" href=\"#carouselCaptions\" role=\"button\" data-slide=\"prev\">
                <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Previous</span>
              </a>
              <a class=\"carousel-control-next\" href=\"#carouselCaptions\" role=\"button\" data-slide=\"next\">
                <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class=\"col-lg\">
      <div class=\"row\">
        <div class=\"col-lg\">
          <b>latest</b>
          <br>
          <span class =\"cash-text extra-detailed quote-attribute\" id=\"latestPrice\" type=\"cash\"></span>
          <div id=\"changePercent-container\">
            <span class =\"cash-text detailed quote-attribute\" change=\"yes\" id=\"change\" type=\"cash\"></span>
            (<span class =\"cash-text detailed quote-attribute\" change=\"yes\" id=\"changePercent\" type=\"percent\"></span>)
          </div>
          <hr>
          <div class=\"row\">
            <div class=\"col-sm\">
              <b>Open</b>
              <br>
              <span class =\"cash-text detailed quote-attribute\" id=\"open\" type=\"cash\"></span>
              <br>
              <span name=\"openTime\" isDate=\"yes\" isTime=\"yes\" class=\"badge badge-pill badge-secondary pointer tooltips\">date/time</span>
            </div>
            <div class=\"col-sm\">
              <b>Close</b>
              <br>
              <span class =\"cash-text detailed quote-attribute\" id=\"close\" type=\"cash\"></span>
              <br>
              <span name=\"closeTime\" isDate=\"yes\"  isTime=\"yes\" class=\"badge badge-pill badge-secondary pointer tooltips\">date/time</span>
            </div>
          </div>
          <hr>
          <div class=\"row\">
            <div class=\"col\">
              <b>Low</b><br>
              <span class =\"cash-text detailed quote-attribute\" id=\"low\" type=\"cash\"></span>
            </div>
            <div class=\"col\">
              <b>High</b><br>
              <span class =\"cash-text detailed quote-attribute\" id=\"high\" type=\"cash\"></span>
            </div>
          </div>
        </div>
        <hr>
        <div class=\"col-sm centered\">
          <p class=\"lead\" id=\"date\"></p>
          <p class=\"lead\" id=\"time\"></p>
          <canvas id=\"clock\" width=\"200\" height=\"200\"></canvas>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col-sm\" style=\"text-align:center;\">
          ";
            // line 138
            if ((($context["shares"] ?? null) != 0)) {
                // line 139
                echo "          <a class=\"btn btn-success\" href=\"/sell?symbol=";
                echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
                echo "\">Sell this stock</a>
          ";
            } else {
                // line 141
                echo "          <a class=\"btn btn-success disabled\" href=\"#\">Buy stock to sell shares</a>
          ";
            }
            // line 143
            echo "        </div>
        <div class=\"col-lg\" style=\"text-align:center;\">
          ";
            // line 145
            if ((($context["shares"] ?? null) != 0)) {
                // line 146
                echo "            <span style=\"color:#2980b9;\">You own <b>";
                echo twig_escape_filter($this->env, ($context["shares"] ?? null), "html", null, true);
                echo "</b> shares of this stock</span>
          ";
            } else {
                // line 148
                echo "            You do not own any shares of this stock
          ";
            }
            // line 150
            echo "        </div>
        <div class=\"col-sm\" style=\"text-align:center;\">
          <a class=\"btn btn-primary\" href=\"/buy?symbol=";
            // line 152
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "\">Buy this stock</a>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col-sm\">
          <b>Latest Update</b><br>
          <span name=\"latestSource\" class=\"badge badge-pill badge-secondary pointer tooltips\">source</span>
        </div>
        <div id=\"latestUpdate\" class=\"col-lg\">
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Extended Price</b><br>
          <span class =\"cash-text detailed quote-attribute\" id=\"extendedPrice\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>Extended % Change</b><br>
          <div id=\"extendedChangePercent-container\">
            <span class =\"cash-text detailed quote-attribute\" change=\"yes\" id=\"extendedChangePercent\" type=\"percent\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>Extended Change</b><br>
          <div id=\"extendedChange-container\">
            <span class =\"cash-text detailed quote-attribute\" change=\"yes\" id=\"extendedChange\" type=\"cash\"></span>
          </div>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>52 Week High</b><br>
          <span class =\"cash-text detailed quote-attribute\" id=\"week52High\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>52 Week Low</b><br>
          <span class =\"cash-text detailed quote-attribute\" id=\"week52Low\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <div id=\"week52change-container\">
            <b>52 Week Change</b><br>
            <span class =\"cash-text detailed advanced-stats-attribute\" id=\"week52change\"  type=\"percent\"></span>
          </div>
        </div>
        <div class=\"col\">
          <div id=\"ytdChange-container\">
            <b>Year-to-Day Change</b><br>
            <span class =\"cash-text detailed quote-attribute\" change=\"yes\" id=\"ytdChange\"  type=\"percent\"></span>
          </div>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Average 30-day volume</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"avg30Volume\"></span>
        </div>
        <div class=\"col\">
          <b>Average 10-day volume</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"avg10Volume\"></span>
        </div>
        <div class=\"col\">
          <b>Latest Volume</b><br>
          <span class =\"detailed quote-attribute\" prefix=\"yes\" id=\"latestVolume\"></span>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Shares Outstanding</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"sharesOutstanding\"></span>
        </div>
        <div class=\"col\">
          <b>Floating Shares</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"float\"></span>
        </div>
        <div class=\"col\">
          <b>Market Cap</b><br>
          <span class =\"detailed quote-attribute\" prefix=\"yes\" id=\"marketCap\"></span>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Total Cash</b><br>
          <span class =\"detailed cash-text advanced-stats-attribute\" prefix=\"yes\" id=\"totalCash\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>Current Debt</b><br>
          <span class =\"detailed cash-text advanced-stats-attribute\" prefix=\"yes\" id=\"currentDebt\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>Revenue</b><br>
          <span class =\"detailed cash-text advanced-stats-attribute\" prefix=\"yes\" id=\"revenue\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>Gross Profit</b><br>
          <span class =\"detailed cash-text advanced-stats-attribute\" prefix=\"yes\" id=\"grossProfit\" type=\"cash\"></span>
        </div>
      </div>

      <br>

      <div class=\"row\">
        <div class=\"col\">
          <b>Total Employees</b><br>
          <span class =\"detailed company-attribute\" prefix=\"yes\" id=\"employees\"></span>
        </div>
        <div class=\"col\">
          <b>Total Revenue</b><br>
          <span class =\"detailed cash-text advanced-stats-attribute\" prefix=\"yes\" id=\"totalRevenue\" ></span>
        </div>
        <div class=\"col\">
          <b>Revenues Per Share</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"revenuePerShare\"></span>
        </div>
        <div class=\"col\">
          <b>Revenues Per Employee</b><br>
          <span class =\"detailed advanced-stats-attribute\" prefix=\"yes\" id=\"revenuePerEmployee\"></span>
        </div>
      </div>

      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Profit Margin</b><br>
          <div id=\"profitMargin-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"profitMargin\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>Debt To Equity</b><br>
          <div id=\"debtToEquity-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"debtToEquity\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>Enterprise Value</b><br>
          <span class =\"cash-text detailed advanced-stats-attribute\" prefix=\"yes\" id=\"enterpriseValue\" type=\"cash\"></span>
        </div>
        <div class=\"col\">
          <b>Beta</b><br>
          <span class =\"detailed advanced-stats-attribute\" round=\"yes\" id=\"beta\"></span>
        </div>
      </div>



      <hr>

      <div class=\"row\">
        <div class=\"col\">
          <b>Price-sales ratio</b><br>
          <div id=\"priceToSales-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"priceToSales\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>Price-Book ratio</b><br>
          <div id=\"priceToBook-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"priceToBook\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>Forward price-to-earnings</b><br>
          <div id=\"forwardPERatio-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"forwardPERatio\"></span>
          </div>
        </div>
        <div class=\"col\">
          <b>PEG ratio</b><br>
          <div id=\"pegRatio-container\">
            <span class =\"detailed advanced-stats-attribute\" change=\"yes\" id=\"pegRatio\"></span>
          </div>
        </div>
      </div>


    </div>
  </div>
  <hr>
  <div class=\"row\">
    <div class=\"col\">
      <b class=\"sub-heading display-4\">Charts</b> <br>
      <div class=\"container-fluid\">
        <ul class=\"nav nav-pills mb-3\" id=\"pills-tab\" role=\"tablist\">
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab1\" data-toggle=\"pill\" href=\"#chart1\" role=\"tab\" aria-controls=\"chart1\" aria-selected=\"true\">1 Day</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link active\" id=\"tab2\" data-toggle=\"pill\" href=\"#chart2\" role=\"tab\" aria-controls=\"chart2\" aria-selected=\"false\">1 Month</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab3\" data-toggle=\"pill\" href=\"#chart3\" role=\"tab\" aria-controls=\"chart3\" aria-selected=\"false\">3 Months</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab4\" data-toggle=\"pill\" href=\"#chart4\" role=\"tab\" aria-controls=\"chart4\" aria-selected=\"false\">6 Months</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab5\" data-toggle=\"pill\" href=\"#chart5\" role=\"tab\" aria-controls=\"chart5\" aria-selected=\"false\">1 Year</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab6\" data-toggle=\"pill\" href=\"#chart6\" role=\"tab\" aria-controls=\"chart6\" aria-selected=\"false\">2 Years</a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" id=\"tab7\" data-toggle=\"pill\" href=\"#chart7\" role=\"tab\" aria-controls=\"chart7\" aria-selected=\"false\">5 Years</a>
          </li>
        </ul>
        <div class=\"tab-content\" id=\"pills-tabContent\">
          <div class=\"tab-pane fade\" id=\"chart1\" role=\"tabpanel\" aria-labelledby=\"tab1\">
            <div id=\"priceHistory1d\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade show active\" id=\"chart2\" role=\"tabpanel\" aria-labelledby=\"tab2\">
            <div id=\"priceHistory1m\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade\" id=\"chart3\" role=\"tabpanel\" aria-labelledby=\"tab3\">
            <div id=\"priceHistory3m\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade\" id=\"chart4\" role=\"tabpanel\" aria-labelledby=\"tab4\">
            <div id=\"priceHistory6m\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade\" id=\"chart5\" role=\"tabpanel\" aria-labelledby=\"tab5\">
            <div id=\"priceHistory1y\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade\" id=\"chart6\" role=\"tabpanel\" aria-labelledby=\"tab6\">
            <div id=\"priceHistory2y\" class=\"container\"></div>
          </div>
          <div class=\"tab-pane fade\" id=\"chart7\" role=\"tabpanel\" aria-labelledby=\"tab7\">
            <div id=\"priceHistory5y\" class=\"container\"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class=\"display-4\" style=\"text-align:center\">
    Trends for average stock prices
    <div class=\"container-fluid\" id=\"regressionGraph\"></div>
  </div>
</main>
";
        } else {
            // line 409
            echo "<main class=\"container-fluid p-5\">
  <form action=\"/detailedQuote?symbol=\" method=\"GET\">
    <div class=\"lead\">
      Try another symbol
    </div>
    <input class=\"form-control\" type=\"text\" name=\"symbol\" placeholder=\"Symbol\" required>
    <button class=\"btn btn-primary\" type=\"submit\" id=\"submit-button\">Lookup</button>
  </form>
</main>
";
        }
        // line 419
        echo "
";
    }

    // line 422
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 423
        if (($context["quoted"] ?? null)) {
            // line 424
            echo "<script type=\"text/javascript\">
    var days = [\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"];
    var months = [\"January\", \"February\", \"March\", \"April\", \"May\", \"June\", \"July\", \"August\", \"September\", \"October\", \"November\", \"December\"];

    var canvas = document.getElementById(\"clock\");
    var ctx = canvas.getContext(\"2d\");
    var radius = canvas.height / 2;
    ctx.translate(radius, radius);
    radius = radius * 0.90
    setInterval(drawClock, 1000);

    ctx.strokeStyle = \"#333\";

    function setDateTime(response, elementID, reqClass, attribute, addTime){
      let resp = response[reqClass][attribute];
      if (resp) {
        let date = new Date(resp);
        let html = getReadableDate(date);
        if (addTime) {
          html += \"<br>\" + getReadableTime(date);
        }
        \$('#'+elementID).html(html);
      }
      else {
        \$('#'+elementID).css('color', 'black');
        \$('#'+elementID).html(\"N/A\");
      }
    }
</script>

<script type=\"text/javascript\">
  \$(document).ready(function(){
    \$.getJSON(\"";
            // line 456
            echo twig_escape_filter($this->env, ($context["b"] ?? null), "html", null, true);
            echo "/stock/";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "/batch?";
            echo twig_escape_filter($this->env, ($context["t"] ?? null), "html", null, true);
            echo "&types=company,quote,previous,advanced-stats,news,peers,largest-trades&displayPercent=true\", function(response){
      console.log(response);
      // classes of requests in batch request
      var reqClasses = ['company','quote','previous','advanced-stats'];

      // iterate over each class of requests
      // get all corresponding HTML elements in the class
      // set respective value for the request class
      reqClasses.forEach(function(className){
        // get elements in the class and loop over them
        let elements = document.getElementsByClassName(className+'-attribute');
        for (let element of elements){
          // get attribute value from request response for respective element
          let resp = response[className][element.id];
          // check for null value
          if(resp){
            // preprocess the response valuePrefix
            if(\$(element).attr('round')) {
              resp = parseFloat(resp).toFixed(3);
            }
            if(\$(element).attr('prefix')) {
              resp = getPrefix(resp);
            }


            // check type of value
            let type =\$(element).attr('type')
            // value is of type change
            if (\$(element).attr('change')){
              // set formatted change
              \$(element).html(formatChange(resp, type));
              // add respective directional caret
              if (parseFloat(resp) > 0.0){
                \$('#'+element.id+'-container').append(\$(caretUp).clone());
              }
              else if(parseFloat(resp) < 0.0){
                \$('#'+element.id+'-container').append(\$(caretDown).clone());
              }
            }
            
            else if (type == 'cash') {
              \$(element).html('\$' + formatNumber(resp));
            }
            else if(type == 'percent') {
              \$(element).html(resp + '%');
            }
            else {
              \$(element).html(resp);
            }

          }
          else {
            \$(element).css('color','black');
            element.innerHTML = \"N/A\";
          }
        }
      });

      response.peers.forEach(function(item, index){
        let col = document.createElement('div');
        \$(col).addClass('col trade-font');
        let a = document.createElement('a');
        \$(a).attr('href', 'detailedQuote?symbol='+item);
        \$(a).html(item);
        \$(col).append(a);
        \$('#peers').append(col);
      });

      \$('#website').attr(\"href\", response.company.website);
      var s='';
      response.company.tags.forEach(function(item, index){
        s += \"<a>\" + item + \"</a><br>\";
      });
      \$('#tags').html(s);

      \$('.tooltips').each(function(index, element){
        let attr_name = \$(element).attr('name')
        let quote_attr = response.quote[attr_name]
        if ((attr_name == \"openTime\"
            || attr_name == \"closeTime\")
            && !quote_attr){
          quote_attr = response.previous.previousDate
          \$(element).removeAttr('isTime')
        }
        tippy(element, {
          content: function(){
            if (\$(element).attr('isDate')) {
              let html = getReadableDate(new Date(quote_attr))
              if(\$(element).attr('isTime')) {
                html += \"<br>\" + getReadableTime(new Date(quote_attr))
              }
              return html
            }
            else {
              return quote_attr
            }
          },
          animation: 'fade',
          arrow: true,
          arrowType: 'sharp',
          delay: [500,5],
          followCursor: false,
        })
      })


      setDateTime(response, 'latestUpdate', 'quote', 'latestUpdate', true);
      setDateTime(response, 'closeTime', 'quote', 'closeTime', true);



      let active = true;
      let slideIdx = 0;
      response.news.forEach(function(item, index){
        \$('#carousel-inner').append(createCarouselItem(item.headline,item.url,item.source,item.summary,new Date(item.datetime), item.image ,active));
        \$('#carousel-indicators').append(createListItem(slideIdx,active));
        slideIdx = slideIdx + 1;
        active = false;
      });
      if (active){
        \$('#carousel-inner').append(createCarouselItem(\"No news for ";
            // line 576
            echo twig_escape_filter($this->env, ($context["stock"] ?? null), "html", null, true);
            echo " stock\",\"#\",\"\",\"\",new Date(),\"\",active));
        \$('#carousel-indicators').append(createListItem(slideIdx,active));
      }


    });

    \$.getJSON(\"";
            // line 583
            echo twig_escape_filter($this->env, ($context["b"] ?? null), "html", null, true);
            echo "/stock/";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "/chart/1d?";
            echo twig_escape_filter($this->env, ($context["t"] ?? null), "html", null, true);
            echo "\", function(chart){
      var labels = [];
      var average = [];
      for (var i = 0; i < chart.length; i++){
        labels[i] = chart[i].label;
        average[i] = chart[i].average;

      }
      Highcharts.chart('priceHistory1d',{
        chart: {
            zoomType: 'x'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
        },
        xAxis: {categories: labels,
                title: {
                  text: 'Dates'
                }},
        title: {text: 'Price History for ' + chart[0].date},
        yAxis: {title: {
                  text: 'Prices (\$)'
        }},
        series: [{
            type: 'line',
            name: 'Average',
            data: average,
            marker: {enabled: false},
            states: { hover: {lineWidth: 0}}
        }
      ]
      });

    });

    \$.getJSON(\"";
            // line 619
            echo twig_escape_filter($this->env, ($context["b"] ?? null), "html", null, true);
            echo "/stock/";
            echo twig_escape_filter($this->env, ($context["symbol"] ?? null), "html", null, true);
            echo "/chart/5y?";
            echo twig_escape_filter($this->env, ($context["t"] ?? null), "html", null, true);
            echo "\", function(chart){
      var arrays = getArrays(chart);
      createDayGraph('priceHistory1m','1 Month', arrays, min(31, chart.length/(12*5)+20));
      createDayGraph('priceHistory3m','3 months', arrays, min(91, chart.length/20 + 20))
      createDayGraph('priceHistory6m','6 months', arrays, min(182, chart.length/10 + 20));
      createDayGraph('priceHistory1y','1 Year', arrays, min(365, chart.length/5 + 20));
      createDayGraph('priceHistory2y','2 Years', arrays, min(365*2, chart.length/2 + 20));
      createDayGraph('priceHistory5y','5 Years', arrays, min(365*5, chart.length));
      var dates = next100Days(chart[arrays.labels.length - 1].date);
      var reg1m = regressionAnalysis(arrays, min(31, chart.length/(12*5)+20));
      var reg3m = regressionAnalysis(arrays, min(91, chart.length/20 + 20));
      var reg6m = regressionAnalysis(arrays, min(182, chart.length/10 + 20));
      var reg1y = regressionAnalysis(arrays,min(365, chart.length/5 + 20));
      var reg2y = regressionAnalysis(arrays, min(365*2, chart.length/2 + 20));
      var reg5y = regressionAnalysis(arrays, min(365*5, chart.length));
      Highcharts.chart('regressionGraph', {
        colorAxis: {
          lineColor: '#e67e22',
          gridLineColor:'#e67e22'
        },
        title: {text: 'Prices forecast'},
        subtitle: {text: 'Regression on different time periods'},
        chart: {
            zoomType: 'x'
        },

        tooltip: {
            valuePrefix: '\$',
            valueDecimals: 2
        },
        xAxis: {
          categories: dates
        },
        yAxis: {
          title: {
            text: 'Prices (\$)'
          }
        },

        series: [{
            data: reg5y.y,
            lineWidth: 2,
            name: 'trend for past ' + reg5y.days + ' days'
        },{
            data: reg2y.y,
            lineWidth: 2,
            name: 'trend for past ' + reg2y.days + ' days'
        },{
            data: reg1y.y,
            lineWidth: 2,
            name: 'trend for past ' + reg1y.days + ' days'
        },{
            data: reg6m.y,
            lineWidth: 2,
            name: 'trend for past ' + reg6m.days + ' days'
        },{
            data: reg3m.y,
            lineWidth: 2,
            name: 'trend for past ' + reg3m.days + ' days'
        },{
            data: reg1m.y,
            lineWidth: 2,
            name: 'trend for past ' + reg1m.days + ' days'
        },
      ]
      });
    });

});
</script>

";
        }
    }

    public function getTemplateName()
    {
        return "detailedQuote.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  740 => 619,  697 => 583,  687 => 576,  560 => 456,  526 => 424,  524 => 423,  520 => 422,  515 => 419,  503 => 409,  243 => 152,  239 => 150,  235 => 148,  229 => 146,  227 => 145,  223 => 143,  219 => 141,  213 => 139,  211 => 138,  99 => 29,  94 => 27,  80 => 15,  78 => 14,  75 => 13,  63 => 7,  58 => 6,  54 => 5,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "detailedQuote.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\detailedQuote.twig");
    }
}

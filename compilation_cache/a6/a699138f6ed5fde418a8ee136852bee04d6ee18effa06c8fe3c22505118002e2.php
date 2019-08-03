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

/* layout.twig */
class __TwigTemplate_2bd23930f8ba16d733d37cdce29da47324508bd7b0ccf00a76bc99ca22977447 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'body' => [$this, 'block_body'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>

<html lang=\"en\">

  <head>
      <meta charset=\"utf-8\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
      <link href=\"/static/favicon.png\" rel=\"icon\">
      <link href=\"/static/styles.css\" rel=\"stylesheet\">

      <link href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">
      <script src=\"https://code.jquery.com/jquery-3.3.1.slim.min.js\" integrity=\"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo\" crossorigin=\"anonymous\"></script>
      <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\" integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\" crossorigin=\"anonymous\"></script>
      <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\" integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\" crossorigin=\"anonymous\"></script>

      <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js\" integrity=\"sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=\" crossorigin=\"anonymous\"></script>

      <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js\" integrity=\"sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=\" crossorigin=\"anonymous\"></script>

      <script src=\"/js/tippy.js\"></script>

      <link rel=\"stylesheet\" type=\"text/css\" href=\"/js/DataTables/datatables.min.css\"/>
      <script type=\"text/javascript\" src=\"/js/DataTables/datatables.min.js\"></script>


      <script src=\"/js/highcharts.js\"></script>

      <script src=\"/js/helpers.js\" charset=\"utf-8\"></script>
      ";
        // line 29
        if ((($context["title"] ?? null) == "Dashboard")) {
            echo "<script src=\"/js/dashCards.js\" charset=\"utf-8\"></script>";
        }
        // line 30
        echo "      ";
        if ((($context["title"] ?? null) == "Detailed Quote")) {
            // line 31
            echo "      <script src=\"/js/clock.js\" charset=\"utf-8\"></script>
      <script src=\"/js/chartRegression.js\" charset=\"utf-8\"></script>
      <script src=\"/js/carouselNews.js\" charset=\"utf-8\"></script>
      ";
        }
        // line 35
        echo "
      <title>Stocker: ";
        // line 36
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
      <script type=\"text/javascript\">
      \$(document).ready(function(){
        if(parseFloat(\"";
        // line 39
        echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
        echo "\") > 0){
          var amt = getNumber(\"";
        // line 40
        echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
        echo "\");
          \$('#withdraw-amount-input').val(amt);
          \$('#withdraw-amount-input').attr('max',amt)
        }
      });

      var caretUp = document.createElement('img');
      \$(caretUp).css('width','16%');
      \$(caretUp).css('height','18%');
      \$(caretUp).attr('src','/static/caret-up.png');
      \$(caretUp).attr('alt','caret top');
      var caretDown = document.createElement('img');
      \$(caretDown).css('width','16%');
      \$(caretDown).css('height','18%');
      \$(caretDown).attr('src','/static/caret-down.png');
      \$(caretDown).attr('alt','caret down');

      </script>
  </head>

    <body>
      ";
        // line 61
        if ((isset($context["session"]) || array_key_exists("session", $context))) {
            // line 62
            echo "        <nav class=\"navbar navbar-expand-md navbar-light bg-light border sticky-top\">
            <a class=\"navbar-brand nav-link ";
            // line 63
            if ((($context["title"] ?? null) == "Dashboard")) {
                echo "disabled";
            }
            echo "\" href=\"/home\">Stocker</span></a>
            <button aria-controls=\"navbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\" class=\"navbar-toggler\" data-target=\"#navbar\" data-toggle=\"collapse\" type=\"button\">
                <span class=\"navbar-toggler-icon\"></span>
            </button>
            <div class=\"collapse navbar-collapse\" id=\"navbar\">
                    <ul class=\"navbar-nav mr-auto mt-2\">
                        <li class=\"nav-item\"><a class=\"nav-link ";
            // line 69
            if ((($context["title"] ?? null) == "Buy")) {
                echo "disabled";
            }
            echo "\" href=\"/buy\">Buy</a></li>
                        <li class=\"nav-item\"><a class=\"nav-link ";
            // line 70
            if ((($context["title"] ?? null) == "Sell")) {
                echo "disabled";
            }
            echo "\" href=\"/sell\">Sell</a></li>
                        <li class=\"nav-item\"><a class=\"nav-link ";
            // line 71
            if ((($context["title"] ?? null) == "Quote")) {
                echo "disabled";
            }
            echo "\" href=\"/quote\">Quote</a></li>
                        <li class=\"nav-item\"><a class=\"nav-link ";
            // line 72
            if ((($context["title"] ?? null) == "History")) {
                echo "disabled";
            }
            echo "\" href=\"/history\">History</a></li>
                    </ul>
                    <ul class=\"navbar-nav ml-auto mt-2\">
                        <div class=\"dropleft\">
                            <li class=\"nav-item dropdown text-capitalize\">
                              <div class=\"dropdown\">
                                <a id=\"user-menu\" class=\"dropdown-toggle\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                  Hi, <strong>";
            // line 79
            echo twig_escape_filter($this->env, ($context["username"] ?? null), "html", null, true);
            echo "</strong>!
                                </a>
                                <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                                  <a class=\"dropdown-header\">Bank amount</a>
                                  <a class=\"dropdown-item disabled\"><span class=\"cash-text\">\$";
            // line 83
            echo twig_escape_filter($this->env, ($context["cash"] ?? null), "html", null, true);
            echo "</span></a>
                                  <a class=\"dropdown-item\">
                                    <button class=\"btn btn-light\" data-toggle=\"modal\" data-target=\"#deposit-modal\">Deposit Cash</button>
                                  </a>
                                  <a class=\"dropdown-item\">
                                    <button class=\"btn btn-light\" data-toggle=\"modal\" data-target=\"#withdraw-modal\">Withdraw Cash</button>
                                  </a>
                                  <a class=\"dropdown-header\">Account Options</a>
                                  <a class=\"dropdown-item\" href=\"/logout\">
                                    <button class=\"btn btn-light\">Logout</button>
                                  </a>
                                </div>
                              </div>
                            </li>
                        </div>
                    </ul>
            </div>
        </nav>


        <div class=\"modal fade\" id=\"deposit-modal\" tabindex=\"-1\" role=\"dialog\">
          <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
              <div class=\"modal-header\">
                <h5 class=\"modal-title\">Deposit Cash</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                  <span aria-hidden=\"true\">&times;</span>
                </button>
              </div>
              <form action=\"/deposit\" method=\"POST\">
                <div class=\"modal-body\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <span class=\"input-group-text\">\$</span>
                      </div>
                      <input name=\"amount\"  type=\"number\" step=\"0.01\" min=\"0.01\" class=\"form-control\" placeholder=\"amount to deposit\">
                    </div>
                </div>
                <div class=\"modal-footer\">
                  <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                  <button type=\"submit\" class=\"btn btn-primary\">Deposit</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class=\"modal fade\" id=\"withdraw-modal\" tabindex=\"-1\" role=\"dialog\">
          <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
              <div class=\"modal-header\">
                <h5 class=\"modal-title\">Withdraw Cash</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                  <span aria-hidden=\"true\">&times;</span>
                </button>
              </div>
              <form action=\"/withdraw\" method=\"POST\">
                <div class=\"modal-body\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <span class=\"input-group-text\">\$</span>
                      </div>
                      <input id=\"withdraw-amount-input\"  name=\"amount\" type=\"number\" step=\"0.01\" class=\"form-control\" placeholder=\"amount to withdraw\">
                    </div>
                </div>
                <div class=\"modal-footer\">
                  <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                  <button type=\"submit\" class=\"btn btn-primary\">Withdraw</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      ";
        }
        // line 158
        echo "
      ";
        // line 159
        $this->displayBlock('body', $context, $blocks);
        // line 161
        echo "

      ";
        // line 163
        if ((isset($context["session"]) || array_key_exists("session", $context))) {
            // line 164
            echo "        <footer class=\"small text-center text-muted\" style=\"padding:20px\">
            Stock feed provided by <a href=\"https://iextrading.com/developer\">IEX</a>. View <a href=\"https://iextrading.com/api-exhibit-a/\">IEX’s Terms of Use</a>.
        </footer>
      ";
        }
        // line 168
        echo "
      ";
        // line 169
        $this->displayBlock('scripts', $context, $blocks);
        // line 172
        echo "    </body>

</html>
";
    }

    // line 159
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 160
        echo "      ";
    }

    // line 169
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 170
        echo "
      ";
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  291 => 170,  287 => 169,  283 => 160,  279 => 159,  272 => 172,  270 => 169,  267 => 168,  261 => 164,  259 => 163,  255 => 161,  253 => 159,  250 => 158,  172 => 83,  165 => 79,  153 => 72,  147 => 71,  141 => 70,  135 => 69,  124 => 63,  121 => 62,  119 => 61,  95 => 40,  91 => 39,  85 => 36,  82 => 35,  76 => 31,  73 => 30,  69 => 29,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout.twig", "C:\\Users\\Faizan\\Desktop\\CS\\workspace\\Stocker\\templates\\layout.twig");
    }
}

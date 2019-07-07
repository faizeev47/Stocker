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

/* login.twig */
class __TwigTemplate_cd457d50660168be866d011991e5ab65c1d23fddefed9086c115e41468513522 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'initScript' => [$this, 'block_initScript'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 31
        return "layout.php";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.php", "login.twig", 31);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 1
    public function block_initScript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "<?php
  // First page in a new session accessed by username

  // Included at the start of all webpages to get database functionality
  include \"DBHandler.php\";

  // If a postback form submission server request
  if(\$_SERVER['REQUEST_METHOD'] == 'POST'){
    // Authenticate user details from the database by getting user ID
    \$id_check = DatabaseObject::authUser(\$_POST['username'],\$_POST['password']);
    // A negative number indicates an error in authentcation (connection problem/invalid user)
    if(\$id_check > 0){
      // Start a new session with the valid ID returned
      session_start();
      \$_SESSION['sess_id'] = \$id_check;
      header(\"location:index.php\");
    }
  }
  // If a simple resource webpage get request
  else if(\$_SERVER['REQUEST_METHOD'] == 'GET'){
      // Check whether user already signed in
      session_start();
      \$user = (int)\$_SESSION['sess_id'];
      if(\$user){
        header(\"location:index.php\");
      }
  }
?>
";
    }

    // line 32
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 33
        echo "  <!-- The main banner(jumbotron) at the login page https://getbootstrap.com/docs/4.3/components/jumbotron/ -->
  <div class=\"jumbotron\">
    <!-- CSS class available for typography https://getbootstrap.com/docs/4.3/content/typography/ -->
    <div class=\"display-1\">
      Finance
    </div>
    <div class=\"display-4\">
      Play with stocks
    </div>
  </div>

  <!-- PHP script positioned in the HTML to render the alert message right beneath the banner -->
  <?php if(\$_SERVER['REQUEST_METHOD'] == 'POST'){
    //  Check value returned as the ID with static constants in the DatabaseObject class in DBHandler
    if(\$id_check == DatabaseObject::CONNECTION_PROBLEM){
      echo \"<div class=\\\"alert alert-danger\\\" role=\\\"alert\\\">\";
      echo \"Database not connected!\";
      echo \"</div>\";
    }
    if(\$id_check == DatabaseObject::UNKNOWN_DATA){
      echo \"<div class=\\\"alert alert-primary\\\" role=\\\"alert\\\">\";
      echo \"Username or password incorrect!\";
      echo \"</div>\";
    }
  } ?>

  <!-- Container CSS class that are basically used for responsiveness -->
  <main class=\"container p-5\">
    <!-- A form which postbacks to same page from user authentication and login -->
    <h4 style=\"font-weight:2px;\">Sign in:</h4>
    <form action=\"login.php\" method=\"POST\">
        <!-- Bootstrap class to keep all the objects in a form consistently formated -->
        <div class=\"form-group\">
            <input autocomplete=\"off\" autofocus class=\"form-control\" name=\"username\" placeholder=\"Username\" type=\"text\" required>
        </div>
        <div class=\"form-group\">
            <input class=\"form-control\" name=\"password\" placeholder=\"Password\" type=\"password\" required>
        </div>
        <a class=\"nav-link\" href=\"register.php\">Register if you dont have an account</a>
        <button class=\"btn btn-primary\" type=\"submit\" id=\"submit-button\">Log In</button>
    </form>
  </main>
";
    }

    public function getTemplateName()
    {
        return "login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 33,  83 => 32,  51 => 2,  47 => 1,  36 => 31,);
    }

    public function getSourceContext()
    {
        return new Source("", "login.twig", "C:\\Users\\Faizan\\Desktop\\6\\Web Technologies\\lab\\project\\twiggingv2\\templates\\login.twig");
    }
}

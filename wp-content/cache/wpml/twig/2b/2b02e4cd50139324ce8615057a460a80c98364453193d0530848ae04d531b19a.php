<?php

/* reset-pro-trans-config.twig */
class __TwigTemplate_ef87ccbe4783ef2db6f8f921773008fab07c59e47a12f8314cc4d2c1e8f124c1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"icl_cyan_box\" id=\"";
        echo twig_escape_filter($this->env, (isset($context["placeHolder"]) ? $context["placeHolder"] : null));
        echo "\">
\t<h3>";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "title", array()), "html", null, true);
        echo "</h3>

\t<div class=\"icl_form_errors\">
\t\t";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "alert1", array()), "html", null, true);
        echo "
\t\t<br/>
\t\t";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "alert2", array()), "html", null, true);
        echo "
\t</div>
\t<p style=\"padding:6px;\">
\t\t<input id=\"icl_reset_pro_check\" type=\"checkbox\" value=\"1\"/>
\t\t&nbsp;<label for=\"icl_reset_pro_check\">";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "checkBoxLabel", array()), "html", null, true);
        echo "</label>
\t</p>

\t<p style=\"padding:6px;\">
\t\t<a id=\"icl_reset_pro_but\" href=\"#\" class=\"button-primary button-primary-disabled\">
\t\t\t";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "button", array()), "html", null, true);
        echo "
\t\t</a><span class=\"spinner\"></span>
\t</p>

</div>
<br clear=\"all\"/>";
    }

    public function getTemplateName()
    {
        return "reset-pro-trans-config.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 16,  42 => 11,  35 => 7,  30 => 5,  24 => 2,  19 => 1,);
    }
}
/* <div class="icl_cyan_box" id="{{ placeHolder|e }}">*/
/* 	<h3>{{ strings.title }}</h3>*/
/* */
/* 	<div class="icl_form_errors">*/
/* 		{{ strings.alert1 }}*/
/* 		<br/>*/
/* 		{{ strings.alert2 }}*/
/* 	</div>*/
/* 	<p style="padding:6px;">*/
/* 		<input id="icl_reset_pro_check" type="checkbox" value="1"/>*/
/* 		&nbsp;<label for="icl_reset_pro_check">{{ strings.checkBoxLabel }}</label>*/
/* 	</p>*/
/* */
/* 	<p style="padding:6px;">*/
/* 		<a id="icl_reset_pro_but" href="#" class="button-primary button-primary-disabled">*/
/* 			{{ strings.button }}*/
/* 		</a><span class="spinner"></span>*/
/* 	</p>*/
/* */
/* </div>*/
/* <br clear="all"/>*/

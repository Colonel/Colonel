<?php

/* @Base/base.html.twig */
class __TwigTemplate_599358ccec53238f98fec531175fc02f3c0c56425c8c145715c0c46561bc1f4b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <title>Hello</title>
</head>
<body>

";
        // line 8
        $this->displayBlock('content', $context, $blocks);
        // line 10
        echo "
</body>
</html>";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "@Base/base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 8,  31 => 10,  29 => 8,  20 => 1,);
    }
}

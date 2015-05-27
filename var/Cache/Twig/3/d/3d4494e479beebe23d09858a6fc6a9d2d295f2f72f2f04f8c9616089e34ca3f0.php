<?php

/* @Base/base.html.twig */
class __TwigTemplate_3d4494e479beebe23d09858a6fc6a9d2d295f2f72f2f04f8c9616089e34ca3f0 extends Twig_Template
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

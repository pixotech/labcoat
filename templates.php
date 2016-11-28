<?php

namespace Labcoat;

use Labcoat\Templates\Template;

require_once __DIR__ . '/vendor/autoload.php';

function is_include_token(\Twig_Token $token)
{
    return is_name_token($token) && in_array($token->getValue(), ['include', 'embed', 'extends']);
}

function is_name_token(\Twig_Token $token)
{
    return $token->getType() == \Twig_Token::NAME_TYPE;
}

function is_variable_end(\Twig_Token $token)
{
    return $token->getType() == \Twig_Token::VAR_END_TYPE;
}

function is_variable_start(\Twig_Token $token)
{
    return $token->getType() == \Twig_Token::VAR_START_TYPE;
}

if ($argc < 2) {
    die("Please enter a template path\n");
}
$path = $argv[1];
if (!is_file($path)) {
    die("Invalid template path\n");
}

$content = file_get_contents($path);

$includedTemplates = [];
$variables = [];

if (false) {
    try {
        $lexer = new \Twig_Lexer(new \Twig_Environment());
        $tokens = $lexer->tokenize($content);
        $inVariable = false;
        $variable = '';
        while (!$tokens->isEOF()) {
            $token = $tokens->next();
            if ($token->getType() == \Twig_Token::NAME_TYPE) {
                print "  " . $token->getValue() . "\n";
            }
            if ($inVariable) {
                print $token->typeToEnglish($token->getType()) . "\n";
                if (is_variable_end($token)) {
                    $variables[] = $variable;
                    $inVariable = false;
                    continue;
                }
                $variable .= $token->getValue();
            }
            if (is_variable_start($token)) {
                $inVariable = true;
                $variable = '';
                continue;
            }
            if (is_include_token($token)) {
                $value = $token->getValue();
                $next = $tokens->next()->getValue();
                if ($next == '(') $next = $tokens->next()->getValue();
                $includedTemplates[$value][] = $next;
            }
        }

        print_r([
            'variables' => $variables,
            'templates' => $includedTemplates,
        ]);

    } catch (\Twig_Error_Syntax $e) {
        die("Syntax error\n");
    }
}

if (true) {
    $env = new \Twig_Environment();
    $lexer = new \Twig_Lexer(new \Twig_Environment());
    $parser = new \Twig_Parser($env);
    $parsed = $parser->parse($lexer->tokenize($content));
    print $parsed;
}

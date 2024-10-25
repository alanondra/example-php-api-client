<?php

declare(strict_types=1);

// https://mlocati.github.io/php-cs-fixer-configurator/

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
	->in([
		'src',
		'tests',
	])
	->exclude([
		'vendor',
	])
	->name([
		'*.php'
	]);

return (new Config())
	->setFinder($finder)
	->setIndent("\t")
	->setRiskyAllowed(true)
	// ->setUsingCache(true)
	->setRules([
		'@PSR12' => true,
		'align_multiline_comment' => [
			'comment_type' => 'all_multiline',
		],
		'array_indentation' => true,
		'array_syntax' => true,
		'assign_null_coalescing_to_coalesce_equal' => true,
		'attribute_empty_parentheses' => true,
		'backtick_to_shell_exec' => true,
		'cast_spaces' => true,
		'clean_namespace' => true,
		'concat_space' => [
			'spacing' => 'one',
		],
		'declare_parentheses' => true,
		'explicit_indirect_variable' => true,
		'explicit_string_variable' => true,
		'include' => true,
		'integer_literal_case' => true,
		'lambda_not_used_import' => true,
		'list_syntax' => true,
		'magic_constant_casing' => true,
		'magic_method_casing' => true,
		'method_chaining_indentation' => true,
		'multiline_whitespace_before_semicolons' => true,
		'native_function_casing' => true,
		'native_type_declaration_casing' => true,
		'no_alias_language_construct_call' => true,
		'no_alternative_syntax' => [
			'fix_non_monolithic_code' => false,
		],
		'no_binary_string' => true,
		'no_empty_phpdoc' => true,
		'no_empty_statement' => true,
		'no_leading_namespace_whitespace' => true,
		'no_mixed_echo_print' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
		'no_null_property_initialization' => true,
		'no_short_bool_cast' => true,
		'no_singleline_whitespace_before_semicolons' => true,
		'no_spaces_around_offset' => true,
		'no_superfluous_elseif' => true,
		'no_trailing_comma_in_singleline' => true,
		'no_unset_cast' => true,
		'no_unused_imports' => true,
		'no_useless_concat_operator' => true,
		'no_useless_else' => true,
		'no_useless_nullsafe_operator' => true,
		'no_useless_return' => true,
		'no_whitespace_before_comma_in_array' => true,
		'normalize_index_brace' => true,
		'nullable_type_declaration' => true,
		'nullable_type_declaration_for_default_null_value' => true,
		'numeric_literal_separator' => [
			'override_existing' => true,
		],
		'object_operator_without_whitespace' => true,
		'octal_notation' => true,
		'operator_linebreak' => true,
		'phpdoc_add_missing_param_annotation' => true,
		'phpdoc_indent' => true,
		'phpdoc_inline_tag_normalizer' => true,
		'phpdoc_line_span' => true,
		'phpdoc_no_access' => true,
		'phpdoc_no_alias_tag' => true,
		'phpdoc_no_package' => true,
		'phpdoc_no_useless_inheritdoc' => true,
		'phpdoc_order' => [
			'order' => [
				'param',
				'return',
				'throws',
				'custom',
			],
		],
		'phpdoc_param_order' => true,
		'phpdoc_return_self_reference' => true,
		'phpdoc_scalar' => true,
		'phpdoc_single_line_var_spacing' => true,
		'phpdoc_summary' => true,
		'phpdoc_tag_casing' => true,
		'phpdoc_trim' => true,
		'phpdoc_trim_consecutive_blank_line_separation' => true,
		'phpdoc_types' => true,
		'phpdoc_var_annotation_correct_order' => true,
		'phpdoc_var_without_name' => true,
		'return_assignment' => true,
		'return_to_yield_from' => true,
		'self_static_accessor' => true,
		'semicolon_after_instruction' => true,
		'simple_to_complex_string_variable' => true,
		'simplified_if_return' => true,
		'simplified_null_return' => true,
		'single_line_comment_spacing' => true,
		'single_line_comment_style' => [
			'comment_types' => [
				'asterisk',
			],
		],
		'single_quote' => true,
		'space_after_semicolon' => true,
		'switch_continue_to_break' => true,
		'ternary_to_null_coalescing' => true,
		'trim_array_spaces' => true,
		'type_declaration_spaces' => true,
		'types_spaces' => true,
		'whitespace_after_comma_in_array' => true,
	]);

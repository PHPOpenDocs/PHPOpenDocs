<?php

declare(strict_types = 1);

namespace PHPFunding;

class PeopleList
{
    /**
     * @var PHPPerson[]
     */
    private array $people;


    public function __construct()
    {
        $this->init();
    }


    public function init()
    {
        $people = [];

        $people[] = (new PHPPerson('AllenJB'))
            ->addRfc_8_0('https://wiki.php.net/rfc/pdo_default_errmode', 'Change Default PDO Error Mode');

        $people[] = (new PHPPerson('Benjamin Eberlei'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/dom_living_standard_api',
                'Implement new DOM Living Standard APIs in ext/dom'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/attributes_v2', 'Attributes v2')
            ->addRfc_8_0('https://wiki.php.net/rfc/attribute_amendments', 'Attribute Amendments')
            ->addRfc_8_0('https://wiki.php.net/rfc/shorter_attribute_syntax_change', 'Shorter Attribute Syntax Change');

        $people[] = (new PHPPerson('Christoph M. Becker'))
            ->addRfc_8_0('https://wiki.php.net/rfc/unbundle_xmlprc', 'Unbundle ext/xmlrpc');

        $people[] = (new PHPPerson('Danack'))
            ->addRfc_8_0('https://wiki.php.net/rfc/mixed_type_v2', 'Mixed Type v2')
            ->addGithubSponsor('https://github.com/sponsors/Danack');

        $people[] = (new PHPPerson('Derick Rethans'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/shorter_attribute_syntax_change',
                'Shorter Attribute Syntax Change'
            )
            ->addGithubSponsor('https://github.com/sponsors/derickr');

        $people[] = (new PHPPerson('Dmitry Stogov'))
            ->addRfc_8_0('https://wiki.php.net/rfc/jit', 'JIT');

        $people[] = (new PHPPerson('Eliot Lear'))
            ->addRfc_8_0('https://wiki.php.net/rfc/add-cms-support', 'Add CMS Support');

        $people[] = (new PHPPerson('Gabriel Caruso'))
            ->addRfc_8_0('https://wiki.php.net/rfc/magic-methods-signature', 'Ensure correct signatures of magic methods')
            ->addRfc_8_0('https://wiki.php.net/todo/php80#release_managers', 'PHP 8 Release Manager')
            ->addGithubSponsor('https://github.com/sponsors/carusogabriel')
        ;

        $people[] = (new PHPPerson('George Peter Banyard'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/locale_independent_float_to_string',
                'Locale-independent float to string cast'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/saner-numeric-strings',
                'Saner numeric strings'
            )
            ->addGithubSponsor('https://github.com/sponsors/Girgias');


        $people[] = (new PHPPerson('Ilija Tovilo'))
            ->addRfc_8_0('https://wiki.php.net/rfc/throw_expression', 'throw expression')
            ->addRfc_8_0('https://wiki.php.net/rfc/match_expression_v2', 'Match expression v2')
            ->addRfc_8_0('https://wiki.php.net/rfc/nullsafe_operator', 'Nullsafe operator');

        $people[] = (new PHPPerson('Mark Randall'))
            ->addRfc_8_0('https://wiki.php.net/rfc/get_debug_type', 'get_debug_type');

        $people[] = (new PHPPerson('Martin Schröder'))
            ->addRfc_8_0('https://wiki.php.net/rfc/attributes_v2', 'Attributes v2')
            ->addRfc_8_0('https://wiki.php.net/rfc/shorter_attribute_syntax', 'Shorter Attribute Syntax');

        $people[] = (new PHPPerson('Máté Kocsis'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/locale_independent_float_to_string',
                'Locale-independent float to string cast'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/mixed_type_v2', 'Mixed Type v2');

        $people[] = (new PHPPerson('Max Semenik'))
            ->addRfc_8_0('https://wiki.php.net/rfc/non-capturing_catches', 'non-capturing catches');

        $people[] = (new PHPPerson('Nicolas Grekas'))
            ->addRfc_8_0('https://wiki.php.net/rfc/stringable', 'Add Stringable interface');

        $people[] = (new PHPPerson('Nikita Popov'))
            ->addRfc_8_0('https://wiki.php.net/rfc/weak_maps', 'Weak maps')
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/consistent_type_errors',
                'Consistent type errors for internal functions'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/lsp_errors',
                'Always generate fatal error for incompatible method signatures'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/union_types_v2', 'Union Types 2.0')
            ->addRfc_8_0('https://wiki.php.net/rfc/variable_syntax_tweaks', 'Variable Syntax Tweaks')
            ->addRfc_8_0('https://wiki.php.net/rfc/static_return_type', 'Static return type')
            ->addRfc_8_0('https://wiki.php.net/rfc/class_name_literal_on_object', 'Allow ::class on objects')
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/abstract_trait_method_validation',
                'Validation for abstract trait methods'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/token_as_object',
                'Object-based token_get_all() alternative'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/trailing_comma_in_parameter_list',
                'Allow trailing comma in parameter list'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/arithmetic_operator_type_checks',
                'Stricter type checks for arithmetic/bitwise operators'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/constructor_promotion',
                'https://wiki.php.net/rfc/constructor_promotion'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/stable_sorting', 'Make sorting stable')
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/string_to_number_comparison',
                'Saner string to number comparisons'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/namespaced_names_as_token',
                'Treat namespaced names as single token'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/named_params', 'Named Arguments')
            ->addRfc_8_0('https://wiki.php.net/rfc/engine_warnings', 'Reclassifying engine warnings');

        $people[] = (new PHPPerson('Pedro Magalhães'))
            ->addRfc_8_0('https://wiki.php.net/rfc/negative_array_index', 'Arrays starting with a negative index')
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/inheritance_private_methods',
                'Remove inappropriate inheritance signature checks on private methods'
            );

        $people[] = (new PHPPerson('Philipp Tanlak'))
            ->addRfc_8_0('https://wiki.php.net/rfc/str_contains', 'str_contains');

        $people[] = (new PHPPerson('Sara Golemon'))
            ->addRfc_8_0('https://wiki.php.net/todo/php80#release_managers', 'PHP 8 Release Manager')
            ->addGithubSponsor('https://github.com/sponsors/sgolemon');




        $people[] = (new PHPPerson('Theodore Brown'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/shorter_attribute_syntax',
                'Shorter Attribute Syntax'
            );

        $people[] = (new PHPPerson('Thomas Weinert'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/dom_living_standard_api',
                'Implement new DOM Living Standard APIs in ext/dom'
            );

        $people[] = (new PHPPerson('Tyson Andre'))
            ->addRfc_8_0('https://wiki.php.net/rfc/always_enable_json', 'Always available JSON extension')
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/throwable_string_param_max_len',
                'Configurable string length in getTraceAsString()'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/trailing_comma_in_closure_use_list',
                'Allow trailing comma in closure use lists'
            )
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/phar_stop_autoloading_metadata',
                "Don't automatically unserialize Phar metadata outside getMetadata()"
            );

        $people[] = (new PHPPerson('Will Hudgins'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/add_str_starts_with_and_ends_with_functions',
                'Add str_starts_with() and str_ends_with() functions'
            );

        $people[] = (new PHPPerson('Zeev Suraski'))
            ->addRfc_8_0('https://wiki.php.net/rfc/jit', 'JIT');

        $this->people = $people;
    }

    /**
     * @return PHPPerson[]
     */
    public function getPeople(): array
    {
        return $this->people;
    }
}

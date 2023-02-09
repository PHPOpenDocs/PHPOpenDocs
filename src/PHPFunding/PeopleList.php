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


    public function init(): void
    {
        $people = [];

        $people[] = (new PHPPerson('Aaron Piotrowski'))
            ->addRfc_8_1('https://wiki.php.net/rfc/fibers', 'Fibres')
            ->addGithubSponsor('https://github.com/sponsors/amphp');

        $people[] = (new PHPPerson('AllenJB'))
            ->addRfc_8_0('https://wiki.php.net/rfc/pdo_default_errmode', 'Change Default PDO Error Mode');

        // https://github.com/sponsors/ramsey

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

        $people[] = (new PHPPerson('David Gebler'))
            ->addRfc_8_1('https://wiki.php.net/rfc/fsync_function', 'fsync() Function');

        $people[] = (new PHPPerson('Derick Rethans'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/shorter_attribute_syntax_change',
                'Shorter Attribute Syntax Change'
            )
            ->addGithubSponsor('https://github.com/sponsors/derickr');

        $people[] = (new PHPPerson('Kamil Tekiela aka Dharman'))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/mysqli_default_errmode',
                'Change Default mysqli Error Mode',
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/mysqli_fetch_column',
                'Add fetch_column method to mysqli',
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/mysqli_bind_in_execute',
                'Mysqli bind in execute'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/autovivification_false',
                'Deprecate autovivification on false'
            );
        //->addGithubSponsor('');https://github.com/kamil-tekiela

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
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/explicit_octal_notation',
                'Explicit octal integer literal notation'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/pure-intersection-types',
                'Pure intersection types'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/implicit-float-int-deprecate',
                'Deprecate implicit non-integer-compatible float to int conversions'
            )
            ->addGithubSponsor('https://github.com/sponsors/Girgias');

        $people[] = (new PHPPerson('Ilija Tovilo'))
            ->addRfc_8_0('https://wiki.php.net/rfc/throw_expression', 'throw expression')
            ->addRfc_8_0('https://wiki.php.net/rfc/match_expression_v2', 'Match expression v2')
            ->addRfc_8_0('https://wiki.php.net/rfc/nullsafe_operator', 'Nullsafe operator')
            ->addRfc_8_1('https://wiki.php.net/rfc/enumerations', 'Enumerations')
            ->addGithubSponsor("https://github.com/sponsors/iluuu1994");

        $people[] = (new PHPPerson('Joe Watkins aka Krakjoe '))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/is_literal',
                'is_Literal'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/partial_function_application',
                'Partial Function Application'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/first_class_callable_syntax',
                'First-class callable syntax'
            )
            ->addGithubSponsor("https://github.com/sponsors/krakjoe");

//        $people[] = (new PHPPerson('Juliette'))
//            ->addMisc(
//                'https://github.com/squizlabs/PHP_CodeSniffer',
//                'PHP CodeSniffer'
//            )
//            ->addMisc(
//                'https://profiles.wordpress.org/jrf/',
//                'Wordpress core team'
//            )
//            ->addGithubSponsor('https://github.com/sponsors/jrfnl');

        $people[] = (new PHPPerson('Larry Garfield'))
            ->addRfc_8_1('https://wiki.php.net/rfc/enumerations', 'Enumerations')
            ->addRfc_8_1('https://wiki.php.net/rfc/pipe-operator-v2', 'Pipe Operator v2')
            ->addGithubSponsor("https://github.com/sponsors/Crell");

        $people[] = (new PHPPerson('Levi Morrison '))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/partial_function_application',
                'Partial Function Application'
            );

        $people[] = (new PHPPerson('Mark Randall'))
            ->addRfc_8_0('https://wiki.php.net/rfc/get_debug_type', 'get_debug_type');

        $people[] = (new PHPPerson('Marco Pivetta aka Ocramius'))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/make-reflection-setaccessible-no-op',
                'Make reflection setAccessible() no-op'
            )
            ->addMisc(
                'https://github.com/Roave/SecurityAdvisories',
                'Roave Security Advisories'
            )
            ->addMisc(
                'https://github.com/Ocramius/ProxyManager',
                'ProxyManager'
            )
            ->addGithubSponsor("https://github.com/sponsors/Ocramius");

        $people[] = (new PHPPerson('Martin Schröder'))
            ->addRfc_8_0('https://wiki.php.net/rfc/attributes_v2', 'Attributes v2')
            ->addRfc_8_0('https://wiki.php.net/rfc/shorter_attribute_syntax', 'Shorter Attribute Syntax');

        $people[] = (new PHPPerson('Matt Brown'))
            ->addRfc_8_1('https://wiki.php.net/rfc/noreturn_type', 'noreturn type');
            // https://github.com/muglug

        $people[] = (new PHPPerson('Máté Kocsis'))
            ->addRfc_8_0(
                'https://wiki.php.net/rfc/locale_independent_float_to_string',
                'Locale-independent float to string cast'
            )
            ->addRfc_8_0('https://wiki.php.net/rfc/mixed_type_v2', 'Mixed Type v2')
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/internal_method_return_types',
                'Add return type declarations for internal methods'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/is_literal',
                'Is_Literal'
            );
        //https://github.com/kocsismate

        $people[] = (new PHPPerson('Max Semenik'))
            ->addRfc_8_0('https://wiki.php.net/rfc/non-capturing_catches', 'non-capturing catches');

        $people[] = (new PHPPerson('deltragon/Mel Dafert'))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/intldatetimepatterngenerator',
                'Add IntlDatePatternGenerator'
            );

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
            ->addRfc_8_0('https://wiki.php.net/rfc/engine_warnings', 'Reclassifying engine warnings')

            ->addRfc_8_1(
                'https://wiki.php.net/rfc/deprecate_null_to_scalar_internal_arg',
                'Deprecate passing null to non-nullable arguments of internal functions'
            )
            ->addRfc_8_1('https://wiki.php.net/rfc/array_unpacking_string_keys', 'Array unpacking with string keys')
            ->addRfc_8_1('https://wiki.php.net/rfc/restrict_globals_usage', 'Restrict $GLOBALS usage')
            ->addRfc_8_1('https://wiki.php.net/rfc/phase_out_serializable', 'Phasing out Serializable')
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/static_variable_inheritance',
                'Static variables in inherited methods'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/readonly_properties_v2',
                'Readonly properties 2.0'
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/first_class_callable_syntax',
                'First-class callable syntax'
            )
        ;

        $people[] = (new PHPPerson('Ondřej Mirtes'))
            ->addRfc_8_1('https://wiki.php.net/rfc/noreturn_type', 'noreturn type')
            ->addGithubSponsor('https://github.com/sponsors/ondrejmirtes');
        ;

        $people[] = (new PHPPerson('Paul Crovella'))
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/partial_function_application',
                'Partial Function Application'
            );

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


        $people[] = (new PHPPerson('Shivam Mathur'))
            ->addMisc(
                'https://github.com/shivammathur/setup-php',
                'setup-php'
            )
            ->addMisc(
                'https://github.com/shivammathur/homebrew-php',
                'homebrew-php'
            )
            ->addMisc(
                'https://github.com/shivammathur/homebrew-extensions',
                'homebrew-extensions'
            )
            ->addMisc(
                'https://github.com/shivammathur/php-builder',
                'php-builder'
            )
            ->addMisc(
                'https://github.com/shivammathur/php-builder-windows',
                'php-builder-windows'
            )
            ->addGithubSponsor('https://github.com/sponsors/shivammathur');

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
            )
            ->addRfc_8_1(
                'https://wiki.php.net/rfc/is_list',
                'Add array_is_list(array $array): bool'
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

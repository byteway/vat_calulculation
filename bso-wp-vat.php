<?php
/*
Plugin Name: BTW Calculator
Plugin URI: https://byteway.eu/btw-calculator/
Description: A simple VAT calculator. Previously created as HTML and JavaScript, now wrapped into a WordPress Plugin.
Author: Byteway Software Ontwikkeling
Version: 1.0

// Activete the plugin via the WordPress Admin Dashboard.
// Use the de shortcode `[btw_calculator]` to show the calculator in a form.
// Configure: Show text area demo, Show help text, Max Width, Label position.
*/

// Voeg het calculatieformulier toe aan een shortcode
function btw_calculator_form() {
    // Haal de opties op uit de database
    $show_demo = get_option('btw_calculator_show_demo', 'true');
    $show_help = get_option('btw_calculator_show_help', 'true');
    $max_width = get_option('btw_calculator_max_width', '600px');
    $label_position = get_option('btw_calculator_label_position', 'above');
    ob_start();
    ?>
    <div class="btw-calculator" style="max-width: <?php echo esc_attr($max_width); ?>;">
        <div class="form-group label-<?php echo esc_attr($label_position); ?>">
            <?php if ($label_position === 'left' || $label_position === 'right') : ?>
                <div class="row">
                    <?php if ($label_position === 'left') : ?>
                        <div class="small-6 columns">
                            <label for="btwperc" class="text-left">BTW percentage</label>
                        </div>
                        <div class="small-6 columns">
                            <select id="btwperc">
                                <option value="6">6%</option>
                                <option value="9">9%</option>
                                <option value="12">12%</option>
                                <option value="19">19%</option>
                                <option value="21">21%</option>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="small-6 columns">
                            <select id="btwperc">
                                <option value="6">6%</option>
                                <option value="9">9%</option>
                                <option value="12">12%</option>
                                <option value="19">19%</option>
                                <option value="21">21%</option>
                            </select>
                        </div>
                        <div class="small-6 columns">
                            <label for="btwperc" class="text-left">BTW percentage</label>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <label for="btwperc">BTW percentage</label>
                <select id="btwperc">
                    <option value="6">6%</option>
                    <option value="9">9%</option>
                    <option value="12">12%</option>
                    <option value="19">19%</option>
                    <option value="21">21%</option>
                </select>
            <?php endif; ?>
        </div>
        <div class="form-group label-<?php echo esc_attr($label_position); ?>">
            <?php if ($label_position === 'left' || $label_position === 'right') : ?>
                <div class="row">
                    <?php if ($label_position === 'left') : ?>
                        <div class="small-6 columns">
                            <label for="bedragex" class="text-left">Bedrag exc.</label>
                        </div>
                        <div class="small-6 columns">
                            <input type="number" id="bedragex" min="0" max="999999">
                        </div>
                    <?php else : ?>
                        <div class="small-6 columns">
                            <input type="number" id="bedragex" min="0" max="999999">
                        </div>
                        <div class="small-6 columns">
                            <label for="bedragex" class="text-left">Bedrag exc.</label>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <label for="bedragex">Bedrag exc.</label>
                <input type="number" id="bedragex" min="0" max="999999">
            <?php endif; ?>
        </div>
        <div class="form-group label-<?php echo esc_attr($label_position); ?>">
            <?php if ($label_position === 'left' || $label_position === 'right') : ?>
                <div class="row">
                    <?php if ($label_position === 'left') : ?>
                        <div class="small-6 columns">
                            <label for="btw" class="text-left">BTW</label>
                        </div>
                        <div class="small-6 columns">
                            <input type="number" id="btw" min="0" max="9999">
                        </div>
                    <?php else : ?>
                        <div class="small-6 columns">
                            <input type="number" id="btw" min="0" max="9999">
                        </div>
                        <div class="small-6 columns">
                            <label for="btw" class="text-left">BTW</label>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <label for="btw">BTW</label>
                <input type="number" id="btw" min="0" max="9999">
            <?php endif; ?>
        </div>
        <div class="form-group label-<?php echo esc_attr($label_position); ?>">
            <?php if ($label_position === 'left' || $label_position === 'right') : ?>
                <div class="row">
                    <?php if ($label_position === 'left') : ?>
                        <div class="small-6 columns">
                            <label for="bedragin" class="text-left">Bedrag inc.</label>
                        </div>
                        <div class="small-6 columns">
                            <input type="number" id="bedragin" min="0" max="999999">
                        </div>
                    <?php else : ?>
                        <div class="small-6 columns">
                            <input type="number" id="bedragin" min="0" max="999999">
                        </div>
                        <div class="small-6 columns">
                            <label for="bedragin" class="text-left">Bedrag inc.</label>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <label for="bedragin">Bedrag inc.</label>
                <input type="number" id="bedragin" min="0" max="999999">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <button type="button" onclick="clearFields()">Reset</button>
            <button type="button" onclick="calcVAT()">Calculate</button>
        </div>

        <?php if ($show_demo === 'true') : ?>
        <div class="form-group">
            <label for="demo">Result:</label>
            <textarea id="demo" rows="4" cols="25">0,0</textarea>
            <button type="button" onclick="copyToClipboard()">Copy Result</button>
        </div>
        <?php endif; ?>

        <?php if ($show_help === 'true') : ?>
        <div class="help-text">
            <p>1. To calculate the <strong>total amount</strong> <strong>inc</strong>. <strong>VAT</strong> (Bedrag inc.): Select the VAT rate (BTW percentage), type in the Amount excl. (Bedrag exc.) and press the button Calculate. </p>
            <p>2.  To calculate the <strong>amount exc</strong>. (Bedrag exc.) and the <strong>VAT amount</strong> (BTW): Select the VAT rate (BTW percentage), type in the Amount incl. (Bedrag inc.) and press the button Calculate.  </p>
        </div>
        <?php endif; ?>
    </div>

    <script>
    // Rondt een waarde af op twee decimalen
    function roundToTwo(value) {
        return(Math.round(value * 100) / 100);
    }

    // Bereken de BTW en de bedragen
    function calcVAT() {
        var bex = document.getElementById("bedragex").value;
        var btw = document.getElementById("btw").value;
        var bin = document.getElementById("bedragin").value;
        var bperc = document.getElementById("btwperc").value;

        if (bperc > 0 && bex > 0) {
            btw = roundToTwo((bperc/100) * bex);
            document.getElementById("btw").value = btw;
            bin = roundToTwo(Number(bex) + Number(btw));
            document.getElementById("bedragin").value = bin;
        } else if (bperc > 0 && bin > 0) {
            bex = roundToTwo(bin / (1 + (bperc / 100)));
            document.getElementById("bedragex").value = bex;
            btw =  roundToTwo((bperc / 100) * bex);
            document.getElementById("btw").value = btw;
        }

        document.getElementById("demo").value = `BTW Percentage:\t€${bperc}\nBedrag exc.:\t€${bex}\nBTW:\t\t€${btw}\nBedrag inc.: \t€${bin}`;
    }

    // Reset alle velden naar de beginwaarden
    function clearFields() {
        document.getElementById("bedragex").value = '';
        document.getElementById("btw").value = '';
        document.getElementById("bedragin").value = '';
        document.getElementById("btwperc").value = '21';
        document.getElementById("demo").value = '';
    }

    // Kopieer het resultaat naar het klembord
    function copyToClipboard() {
        var copyText = document.getElementById("demo");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Voor mobiele apparaten
        document.execCommand("copy");
        alert("Result copied to clipboard: " + copyText.value);
    }
    </script>
    <style>
    .btw-calculator {
        max-width: <?php echo esc_attr($max_width); ?>;
        margin: 0 auto;
    }
    .btw-calculator .form-group {
        margin-bottom: 15px;
    }
    .label-above {
        display: flex;
        flex-direction: column;
    }
    .label-left, .label-right {
        display: flex;
        align-items: center;
    }
    .label-left .row, .label-right .row {
        display: flex;
        width: 100%;
    }
    .label-left .small-6, .label-right .small-6 {
        flex: 1;
    }
    .label-left label {
        margin-right: 10px;
    }
    .label-right label {
        margin-left: 10px;
    }
    .btw-calculator label {
        margin-bottom: 5px;
    }
    .btw-calculator input, .btw-calculator select, .btw-calculator textarea, .btw-calculator button {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .btw-calculator button {
        margin-top: 10px;
    }
    .help-text {
        margin-top: 20px;
    }
    </style>
    <?php
    return ob_get_clean();
}


// Registreer de shortcode
function register_btw_calculator_shortcode() {
    add_shortcode('btw_calculator', 'btw_calculator_form');
}
add_action('init', 'register_btw_calculator_shortcode');

// Voeg instellingen toe aan het admin menu
function btw_calculator_menu() {
    add_options_page(
        'BTW Calculator Settings',
        'BTW Calculator',
        'manage_options',
        'btw-calculator',
        'btw_calculator_options_page'
    );
}
add_action('admin_menu', 'btw_calculator_menu');

// Instellingenpagina weergeven
function btw_calculator_options_page() {
    ?>
    <div class="wrap">
        <h1>BTW Calculator Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('btw_calculator_options_group');
            do_settings_sections('btw-calculator');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Registreer instellingen
function btw_calculator_settings_init() {
    register_setting('btw_calculator_options_group', 'btw_calculator_show_demo');
    register_setting('btw_calculator_options_group', 'btw_calculator_show_help');
    register_setting('btw_calculator_options_group', 'btw_calculator_max_width');
    register_setting('btw_calculator_options_group', 'btw_calculator_label_position');

    add_settings_section(
        'btw_calculator_settings_section',
        'Display Options',
        'btw_calculator_settings_section_callback',
        'btw-calculator'
    );

    add_settings_field(
        'btw_calculator_show_demo',
        'Show text area demo',
        'btw_calculator_show_demo_render',
        'btw-calculator',
        'btw_calculator_settings_section'
    );

    add_settings_field(
        'btw_calculator_show_help',
        'Show help text',
        'btw_calculator_show_help_render',
        'btw-calculator',
        'btw_calculator_settings_section'
    );

    add_settings_field(
        'btw_calculator_max_width',
        'Max Width',
        'btw_calculator_max_width_render',
        'btw-calculator',
        'btw_calculator_settings_section'
    );

    add_settings_field(
        'btw_calculator_label_position',
        'Label Position',
        'btw_calculator_label_position_render',
        'btw-calculator',
        'btw_calculator_settings_section'
    );
}
add_action('admin_init', 'btw_calculator_settings_init');

function btw_calculator_settings_section_callback() {
    echo 'Configure the display options for the BTW Calculator.';
}

function btw_calculator_show_demo_render() {
    $option = get_option('btw_calculator_show_demo', 'true');
    ?>
    <select name="btw_calculator_show_demo">
        <option value="true" <?php selected($option, 'true'); ?>>True</option>
        <option value="false" <?php selected($option, 'false'); ?>>False</option>
    </select>
    <?php
}

function btw_calculator_show_help_render() {
    $option = get_option('btw_calculator_show_help', 'true');
    ?>
    <select name="btw_calculator_show_help">
        <option value="true" <?php selected($option, 'true'); ?>>True</option>
        <option value="false" <?php selected($option, 'false'); ?>>False</option>
    </select>
    <?php
}

function btw_calculator_max_width_render() {
    $option = get_option('btw_calculator_max_width', '600px');
    ?>
    <input type="text" name="btw_calculator_max_width" value="<?php echo esc_attr($option); ?>">
    <?php
}

function btw_calculator_label_position_render() {
    $option = get_option('btw_calculator_label_position', 'above');
    ?>
    <select name="btw_calculator_label_position">
        <option value="above" <?php selected($option, 'above'); ?>>Above</option>
        <option value="left" <?php selected($option, 'left'); ?>>Left</option>
        <option value="right" <?php selected($option, 'right'); ?>>Right</option>
    </select>
    <?php
}
?>

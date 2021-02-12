

const defaults = {
    // fonts: undefined,
    // name: "fonts",
    // apiUrl: undefined,
    // formats: undefined,
    // filename: "fonts.css",
    // path: "font/",
    // output_filename: 'asset_version.php'
};

function BuildVersionPlugin(options) {
    this.output_filename = 'asset_version.php';
    this.path = null;

    //this.options = Object.assign({}, defaults, options);

    if (options !== undefined) {
        if (options.output_filename !== undefined) {
            this.output_filename = options.output_filename;
        }

        if (options.path !== undefined) {
            console.log("path is " + options.path);
            this.path = options.path;
        }
    }

    console.log("this.output_filename = [" + this.output_filename + "]");
    console.log("path is " + options.path)
}

BuildVersionPlugin.prototype.apply = function(compiler) {
    compiler.plugin('emit', function(compilation, callback) {

        // Create a header string for the generated file:
        let contents = '<?php\n\n';

        contents += "// Auto-generated file\n";
        contents += "// Files in this build\n";

        let assetsFilenames = Object.keys(compilation.assets);
        assetsFilenames.sort();
        // Loop through all compiled assets,
        // adding a new line item for each filename.
        for (let filename in assetsFilenames) {
            contents += (' // '+ assetsFilenames[filename] +'\n');
        }

        contents += '// output_filename [' + this.output_filename + ']\n\n';

        let date = new Date();

        let date_string = ("" + date.getFullYear() + "_" +
           (date.getMonth()+1) + "_" +
           date.getDate() + "_" +
           date.getHours() + "_" +
           date.getMinutes() + "_" +
           date.getSeconds()
        );

        contents += "function getAssetVersion() : string\n";
        contents += "{\n";
        contents += '    return \'' + date_string + '\';\n';
        contents += "}\n";

        let filename = this.output_filename;
        if (this.path != null) {
            filename = this.path + '/' + this.output_filename;
        }

          // Insert this list into the Webpack build as a new file asset:
        compilation.assets[filename] = {
            source: function() {
                return contents;
            },
            size: function() {
                return contents.length;
            }
        };

        callback();
    }.bind(this));
};

module.exports = BuildVersionPlugin;



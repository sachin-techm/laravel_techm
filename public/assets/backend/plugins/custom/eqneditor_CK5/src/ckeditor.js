/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// The editor creator to use.
import ClassicEditorBase from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";

import Essentials from "@ckeditor/ckeditor5-essentials/src/essentials";
import Bold from "@ckeditor/ckeditor5-basic-styles/src/bold";
import Italic from "@ckeditor/ckeditor5-basic-styles/src/italic";
import Heading from "@ckeditor/ckeditor5-heading/src/heading";
import Paragraph from "@ckeditor/ckeditor5-paragraph/src/paragraph";
import SpecialCharacters from "@ckeditor/ckeditor5-special-characters/src/specialcharacters";
import SpecialCharactersEssentials from "@ckeditor/ckeditor5-special-characters/src/specialcharactersessentials";
import Table from "@ckeditor/ckeditor5-table/src/table";
import TableToolbar from "@ckeditor/ckeditor5-table/src/tabletoolbar";

import SourceEditing from "@ckeditor/ckeditor5-source-editing/src/sourceediting";
import ImageInsert from "@ckeditor/ckeditor5-image/src/imageinsert";
import SimpleUploadAdapter from "@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter";

// import ImageResizeEditing from "@ckeditor/ckeditor5-image/src/imageresize/imageresizeediting";
// import ImageResizeHandles from "@ckeditor/ckeditor5-image/src/imageresize/imageresizehandles";
import ImageCaption from "@ckeditor/ckeditor5-image/src/imagecaption";
import ImageResize from "@ckeditor/ckeditor5-image/src/imageresize";
import ImageStyle from "@ckeditor/ckeditor5-image/src/imagestyle";
import ImageToolbar from "@ckeditor/ckeditor5-image/src/imagetoolbar";
import LinkImage from "@ckeditor/ckeditor5-link/src/linkimage";

// CKFinder
import CKFinder from "@ckeditor/ckeditor5-ckfinder/src/ckfinder";
import CKFinderUploadAdapter from "@ckeditor/ckeditor5-adapter-ckfinder/src/uploadadapter";
import Link from "@ckeditor/ckeditor5-link/src/link";

import Indent from "@ckeditor/ckeditor5-indent/src/indent";
import IndentBlock from "@ckeditor/ckeditor5-indent/src/indentblock";

import FontSize from "@ckeditor/ckeditor5-font/src/fontsize";
import FontColor from "@ckeditor/ckeditor5-font/src/fontcolor";
import FontBackgroundColor from "@ckeditor/ckeditor5-font/src/fontbackgroundcolor";

import List from "@ckeditor/ckeditor5-list/src/list";

// Following are essential for CodeCogs Equation Editor
import Image from "@ckeditor/ckeditor5-image/src/image";
import MediaEmbed from "@ckeditor/ckeditor5-media-embed/src/mediaembed";
import EqnEditor5 from "@codecogs/eqneditor-ckeditor5/src/eqneditor5";

import CodeBlock from "@ckeditor/ckeditor5-code-block/src/codeblock";

// import MathType from '@wiris/mathtype-ckeditor5/dist/index.js';

export default class ClassicEditor extends ClassicEditorBase {}

// Plugins to include in the build.
ClassicEditor.builtinPlugins = [
    Essentials,
    Bold,
    Italic,
    Heading,
    Indent,
    IndentBlock,
    FontSize,
    FontColor,
    FontBackgroundColor,
    List,
    Image /* Need by EqnEditor 5 */,
    MediaEmbed /* Need by EqnEditor 5 */,
    EqnEditor5 /* Core of EqnEditor 5 */,
    SpecialCharacters,
    SpecialCharactersEssentials,
    SourceEditing,
    ImageInsert,
    SimpleUploadAdapter,
    CKFinder,
    Table,
    TableToolbar,
    CKFinderUploadAdapter,
    Link,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    LinkImage,
    // MathType,
    CodeBlock,
];

// Editor configuration.
ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            "undo",
            "redo",
            "|",
            "EqnEditor5" /* Added fx button for EqnEditor 5 */,
            "bold",
            "italic",
            "|",
            "numberedList",
            "bulletedList",
            "outdent",
            "indent",
            "|",
            "heading",
            "codeBlock",
            "fontsize",
            "fontColor",
            "fontBackgroundColor",
            "specialCharacters",
            "insertImage",
            "ckfinder",
            "insertTable",
            "sourceEditing",
            // 'MathType',
            // 'ChemType',
        ],
    },
    // This value must be kept in sync with the language defined in webpack.config.js.
    language: "en",
    simpleUpload: {
        // The URL that the images are uploaded to.
        uploadUrl:
            __BASE_URL_JS__ +
            "admin/ckfinder/connector?command=QuickUpload&type=Files&responseType=json",

        // Enable the XMLHttpRequest.withCredentials property.
        withCredentials: false,

        // ckCsrfToken: d5l98dsJq4ssAoGgw6GZ3wUQtf28IhSmAH2H5DoE

        // Headers sent along with the XMLHttpRequest to the upload server.
        // headers: {
        // 	'X-CSRF-TOKEN': 'CSRF-Token',
        // 	Authorization: 'Bearer <JSON Web Token>'
        // }
    },
    ckfinder: {
        // Upload the images to the server using the CKFinder QuickUpload command.
        uploadUrl:
            __BASE_URL_JS__ +
            "admin/ckfinder/connector?command=QuickUpload&type=Files&responseType=json",
        // "admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json",

        // Define the CKFinder configuration (if necessary).
        options: {
            // resourceType: "Images",
        },
        // Open the file manager in the pop-up window.
        // openerMethod: "popup",
    },
    image: {
        toolbar: [
            "imageStyle:block",
            "imageStyle:inline",
            "|",
            // 'imageStyle:side',
            // '|',
            "imageStyle:alignLeft",
            "imageStyle:alignRight",
            "|",
            "imageStyle:alignBlockLeft",
            "imageStyle:alignBlockRight",
            "|",
            "imageStyle:alignCenter",
            "|",
            "toggleImageCaption",
            "imageTextAlternative",
            "|",
            "linkImage",
        ],
        insert: {
            // If this setting is omitted, the editor defaults to 'block'.
            // See explanation below.
            type: "auto",
            // This is the default configuration, you do not need to provide
            // this configuration key if the list content and order reflects your needs.
            // integrations: ["assetManager", "url"],
        },
    },
    table: {
        contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"],
    },
};

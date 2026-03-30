<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{ env('APP_NAME') }} Order Confirmation</title>
        <style media="all" type="text/css">
            /* -------------------------------------
            GLOBAL RESETS
            ------------------------------------- */
            body {
            font-family: Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            line-height: 1.3;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            }
            table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
            }
            table td {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            vertical-align: top;
            }
            /* -------------------------------------
            BODY & CONTAINER
            ------------------------------------- */
            body {
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
            }
            .body {
            background-color: #f4f5f6;
            width: 100%;
            }
            .container {
            margin: 0 auto !important;
            max-width: 600px;
            padding: 0;
            padding-top: 24px;
            width: 600px;
            }
            .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 600px;
            padding: 0;
            }
            /* -------------------------------------
            HEADER, FOOTER, MAIN
            ------------------------------------- */
            .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
            }
            .wrapper {
            box-sizing: border-box;
            padding: 24px;
            }
            .footer {
            clear: both;
            padding-top: 24px;
            text-align: center;
            width: 100%;
            }
            .footer td,
            .footer p,
            .footer span,
            .footer a {
            color: #9a9ea6;
            font-size: 16px;
            text-align: center;
            }
            /* -------------------------------------
            TYPOGRAPHY
            ------------------------------------- */
            p {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 16px;
            }
            a {
            color: #3699ff;
            text-decoration: underline;
            }
            /* -------------------------------------
            BUTTONS
            ------------------------------------- */
            .btn {
            box-sizing: border-box;
            min-width: 100% !important;
            width: 100%;
            }
            .btn > tbody > tr > td {
            padding-bottom: 16px;
            }
            .btn table {
            width: auto;
            }
            .btn table td {
            background-color: #ffffff;
            border-radius: 4px;
            text-align: center;
            }
            .btn a {
            background-color: #ffffff;
            border: solid 2px #3699ff;
            border-radius: 4px;
            box-sizing: border-box;
            color: #3699ff;
            cursor: pointer;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            padding: 8px 20px;
            text-decoration: none;
            text-transform: capitalize;
            }
            .btn-primary table td {
            background-color: #3699ff;
            }
            .btn-primary a {
            background-color: #3699ff;
            border-color: #3699ff;
            color: #ffffff;
            }
            @media all {
            .btn-primary table td:hover {
            background-color: #187de4 !important;
            }
            .btn-primary a:hover {
            background-color: #187de4 !important;
            border-color: #187de4 !important;
            }
            }
            /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
            ------------------------------------- */
            .last {
            margin-bottom: 0;
            }
            .first {
            margin-top: 0;
            }
            .align-center {
            text-align: center;
            }
            .align-right {
            text-align: right;
            }
            .align-left {
            text-align: left;
            }
            .text-link {
            color: #3699ff !important;
            text-decoration: underline !important;
            }
            .clear {
            clear: both;
            }
            .mt0 {
            margin-top: 0;
            }
            .mb0 {
            margin-bottom: 0;
            }
            .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
            }
            .powered-by a {
            text-decoration: none;
            }
            /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 640px) {
            .main p,
            .main td,
            .main span {
            font-size: 16px !important;
            }
            .wrapper {
            padding: 8px !important;
            }
            .content {
            padding: 0 !important;
            }
            .container {
            padding: 0 !important;
            padding-top: 8px !important;
            width: 100% !important;
            }
            .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
            }
            .btn table {
            max-width: 100% !important;
            width: 100% !important;
            }
            .btn a {
            font-size: 16px !important;
            max-width: 100% !important;
            width: 100% !important;
            }
            }
            /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
            ------------------------------------- */
            @media all {
            .ExternalClass {
            width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
            line-height: 100%;
            }
            .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
            }
            #MessageViewBody a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit;
            }
            }
        </style>
    </head>
    <body>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
            <tr>
                <td>&nbsp;</td>
                <td class="container">
                    <div class="content">
                        <!-- START CENTERED WHITE CONTAINER -->
                        <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="1main">
                          <tr>
                        <td>
                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;" width="650">
                            <tbody>
                              <tr>
                                <td class="column column-1"
                                  style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                  width="100%">
                                  <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                    <tr>
                                      <td class="pad"
                                        style="padding-bottom:15px;padding-top:15px;width:100%;padding-right:0px;padding-left:0px;">
                                        <div align="center" class="alignment" style="line-height:10px"><img alt="your logo"
                                            src="{{ asset("assets/backend/media/logos/logo-transparent-horizontal.png") }}"
                                            style="display: block; height: auto; border: 0; width: 195px; max-width: 100%;"
                                            title="your logo" width="195" /></div>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>

                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">
                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td class="wrapper">
                                    <p>Hi {{$user->first_name}},</p>
                                    <p>You have successfully submitted your Test {{ $result->questionSet->set_name }}. </p>

                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                        <tbody>
                                            <tr>
                                                <td align="left">
                                                    Test Date
                                                </td>
                                                <td align="right">
                                                    Result
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    {{ \Helper::getDateFromFormat2($result->created_at) }}
                                                </td>
                                                <td align="right">
                                                    <span style="font-size: 25px; font-weight: 700">{{ ($result->correct_questions * 100) / $result->total_questions }}%</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>

                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                        <tbody>
                                            <tr>
                                                <td align="left">
                                                    Total Questions
                                                </td>
                                                <td align="right">
                                                    {{ $result->total_questions }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Correct Answer
                                                </td>
                                                <td align="right">
                                                    {{ $result->correct_questions }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Wrong Answer
                                                </td>
                                                <td align="right">
                                                    {{ $result->wrong_questions }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Attempt Answer
                                                </td>
                                                <td align="right">
                                                    {{ $result->attempt_questions }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Skip Answer
                                                </td>
                                                <td align="right">
                                                    {{ $result->skip_questions }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Total Marks
                                                </td>
                                                <td align="right">
                                                    {{ $result->total_mark }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Total Positive Marks
                                                </td>
                                                <td align="right">
                                                    {{ $result->total_positive_mark }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Total Negative Marks
                                                </td>
                                                <td align="right">
                                                    {{ $result->total_negative_mark }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Total Time
                                                </td>
                                                <td align="right">
                                                    {{ $result->total_time }} mins
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    Total Time Taken
                                                </td>
                                                <td align="right">
                                                    {{ $result->taken_time }} mins
                                                </td>
                                            </tr>
                                            

                                        </tbody>
                                    </table>

                                    <!-- <p>This is a really simple email template. It's sole purpose is to get the recipient to click the button with no distractions.</p>
                                    <p>Good luck! Hope it works.</p> -->
                                </td>
                            </tr>
                            <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- START FOOTER -->
                        <div class="footer">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <span class="apple-link">{{ env('APP_URL') }} © {{now()->format("Y")}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- END FOOTER -->
                        <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
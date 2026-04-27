<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta content="charset=utf-8"/>
        <style>
            html {
                font-family: sans-serif;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }
            body {
                margin: 0;
            }

            b,
            strong {
                font-weight: bold;
            }

            h1 {
                margin: 0.67em 0;
                font-size: 2em;
            }
            small {
                font-size: 80%;
            }

            img {
                border: 0;
            }
            hr {
                height: 0;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box;
            }
            table {
                border-spacing: 0;
                border-collapse: collapse;
            }
            td,
            th {
                padding: 0;
            }
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            *:before,
            *:after {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            html {
                font-size: 10px;
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            }
            body {
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size: 10px;
                line-height: 1.42857143;
                color: #333;
                background-color: #fff;
            }
            img {
                vertical-align: middle;
            }
            .img-responsive{
                display: block;
                max-width: 100%;
                height: auto;
            }
            .img-rounded {
                border-radius: 6px;
            }
            .img-thumbnail {
                display: inline-block;
                max-width: 100%;
                height: auto;
                padding: 4px;
                line-height: 1.42857143;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                -webkit-transition: all 0.2s ease-in-out;
                -o-transition: all 0.2s ease-in-out;
                transition: all 0.2s ease-in-out;
            }
            .img-circle {
                border-radius: 50%;
            }
            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 1px solid #eee;
            }
            /* h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            .h1,
            .h2,
            .h3,
            .h4,
            .h5,
            .h6 {
                font-family: inherit;
                font-weight: 500;
                line-height: 1.1;
                color: inherit;
            } */
            /* h1 small,
            h2 small,
            h3 small,
            h4 small,
            h5 small,
            h6 small,
            .h1 small,
            .h2 small,
            .h3 small,
            .h4 small,
            .h5 small,
            .h6 small,
            h1 .small,
            h2 .small,
            h3 .small,
            h4 .small,
            h5 .small,
            h6 .small,
            .h1 .small,
            .h2 .small,
            .h3 .small,
            .h4 .small,
            .h5 .small,
            .h6 .small {
                font-weight: normal;
                line-height: 1;
                color: #777;
            } */
            /* h1,
            .h1,
            h2,
            .h2,
            h3,
            .h3 {
                margin-top: 20px;
                margin-bottom: 10px;
            } */
            /* h1 small,
            .h1 small,
            h2 small,
            .h2 small,
            h3 small,
            .h3 small,
            h1 .small,
            .h1 .small,
            h2 .small,
            .h2 .small,
            h3 .small,
            .h3 .small {
                font-size: 65%;
            } */
            /* h4,
            .h4,
            h5,
            .h5,
            h6,
            .h6 {
                margin-top: 10px;
                margin-bottom: 10px;
            }
            h4 small,
            .h4 small,
            h5 small,
            .h5 small,
            h6 small,
            .h6 small,
            h4 .small,
            .h4 .small,
            h5 .small,
            .h5 .small,
            h6 .small,
            .h6 .small {
                font-size: 75%;
            }
            h1,
            .h1 {
                font-size: 36px;
            }
            h2,
            .h2 {
                font-size: 30px;
            }
            h3,
            .h3 {
                font-size: 24px;
            }
            h4,
            .h4 {
                font-size: 18px;
            }
            h5,
            .h5 {
                font-size: 14px;
            }
            h6,
            .h6 {
                font-size: 12px;
            } */
            p {
                margin: 0 0 10px;
            }

            small,
            .small {
                font-size: 85%;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .text-center {
                text-align: center;
            }
            .text-justify {
                text-align: justify;
            }
            .text-nowrap {
                white-space: nowrap;
            }
            .text-lowercase {
                text-transform: lowercase;
            }
            .text-uppercase {
                text-transform: uppercase;
            }
            .text-capitalize {
                text-transform: capitalize;
            }
            .text-muted {
                color: #777;
            }
            .text-primary {
                color: #337ab7;
            }

            .text-success {
                color: #3c763d;
            }
            .text-info {
                color: #31708f;
            }
            .text-warning {
                color: #8a6d3b;
            }
            .text-danger {
                color: #a94442;
            }
            .bg-primary {
                color: #fff;
                background-color: #337ab7;
            }
            .bg-success {
                background-color: #dff0d8;
            }
            .bg-info {
                background-color: #d9edf7;
            }
            .bg-warning {
                background-color: #fcf8e3;
            }
            .bg-danger {
                background-color: #f2dede;
            }
            ul,
            ol {
                margin-top: 0;
                margin-bottom: 10px;
            }
            ul ul,
            ol ul,
            ul ol,
            ol ol {
                margin-bottom: 0;
            }
            .list-unstyled {
                padding-left: 0;
                list-style: none;
            }
            .list-inline {
                padding-left: 0;
                margin-left: -5px;
                list-style: none;
            }
            .list-inline > li {
                display: inline-block;
                padding-right: 5px;
                padding-left: 5px;
            }
            .initialism {
                font-size: 90%;
                text-transform: uppercase;
            }
            address {
                margin-bottom: 20px;
                font-style: normal;
                line-height: 1.42857143;
            }
            .container {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            .container-fluid {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            .row {
                margin-right: -15px;
                margin-left: -15px;
            }
            .col-xs-1,
            .col-sm-1,
            .col-md-1,
            .col-lg-1,
            .col-xs-2,
            .col-sm-2,
            .col-md-2,
            .col-lg-2,
            .col-xs-3,
            .col-sm-3,
            .col-md-3,
            .col-lg-3,
            .col-xs-4,
            .col-sm-4,
            .col-md-4,
            .col-lg-4,
            .col-xs-5,
            .col-sm-5,
            .col-md-5,
            .col-lg-5,
            .col-xs-6,
            .col-sm-6,
            .col-md-6,
            .col-lg-6,
            .col-xs-7,
            .col-sm-7,
            .col-md-7,
            .col-lg-7,
            .col-xs-8,
            .col-sm-8,
            .col-md-8,
            .col-lg-8,
            .col-xs-9,
            .col-sm-9,
            .col-md-9,
            .col-lg-9,
            .col-xs-10,
            .col-sm-10,
            .col-md-10,
            .col-lg-10,
            .col-xs-11,
            .col-sm-11,
            .col-md-11,
            .col-lg-11,
            .col-xs-12,
            .col-sm-12,
            .col-md-12,
            .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-md-12 {
                width: 100%;
            }
            .col-md-11 {
                width: 91.66666667%;
            }
            .col-md-10 {
                width: 83.33333333%;
            }
            .col-md-9 {
                width: 75%;
            }
            .col-md-8 {
                width: 66.66666667%;
            }
            .col-md-7 {
                width: 58.33333333%;
            }
            .col-md-6 {
                width: 50%;
            }
            .col-md-5 {
                width: 41.66666667%;
            }
            .col-md-4 {
                width: 33.33333333%;
            }
            .col-md-3 {
                width: 25%;
            }
            .col-md-2 {
                width: 16.66666667%;
            }
            .col-md-1 {
                width: 8.33333333%;
            }
            .col-xs-1,
            .col-xs-2,
            .col-xs-3,
            .col-xs-4,
            .col-xs-5,
            .col-xs-6,
            .col-xs-7,
            .col-xs-8,
            .col-xs-9,
            .col-xs-10,
            .col-xs-11,
            .col-xs-12 {
                float: left;
            }
            .col-xs-12 {
                width: 100%;
            }
            .col-xs-11 {
                width: 91.66666667%;
            }
            .col-xs-10 {
                width: 83.33333333%;
            }
            .col-xs-9 {
                width: 75%;
            }
            .col-xs-8 {
                width: 66.66666667%;
            }
            .col-xs-7 {
                width: 58.33333333%;
            }
            .col-xs-6 {
                width: 50%;
            }
            .col-xs-5 {
                width: 41.66666667%;
            }
            .col-xs-4 {
                width: 33.33333333%;
            }
            .col-xs-3 {
                width: 25%;
            }
            .col-xs-2 {
                width: 16.66666667%;
            }
            .col-xs-1 {
                width: 8.33333333%;
            }
            .col-xs-pull-12 {
                right: 100%;
            }
            .col-xs-pull-11 {
                right: 91.66666667%;
            }
            .col-xs-pull-10 {
                right: 83.33333333%;
            }
            .col-xs-pull-9 {
                right: 75%;
            }
            .col-xs-pull-8 {
                right: 66.66666667%;
            }
            .col-xs-pull-7 {
                right: 58.33333333%;
            }
            .col-xs-pull-6 {
                right: 50%;
            }
            .col-xs-pull-5 {
                right: 41.66666667%;
            }
            .col-xs-pull-4 {
                right: 33.33333333%;
            }
            .col-xs-pull-3 {
                right: 25%;
            }
            .col-xs-pull-2 {
                right: 16.66666667%;
            }
            .col-xs-pull-1 {
                right: 8.33333333%;
            }
            .col-xs-pull-0 {
                right: auto;
            }
            .col-xs-push-12 {
                left: 100%;
            }
            .col-xs-push-11 {
                left: 91.66666667%;
            }
            .col-xs-push-10 {
                left: 83.33333333%;
            }
            .col-xs-push-9 {
                left: 75%;
            }
            .col-xs-push-8 {
                left: 66.66666667%;
            }
            .col-xs-push-7 {
                left: 58.33333333%;
            }
            .col-xs-push-6 {
                left: 50%;
            }
            .col-xs-push-5 {
                left: 41.66666667%;
            }
            .col-xs-push-4 {
                left: 33.33333333%;
            }
            .col-xs-push-3 {
                left: 25%;
            }
            .col-xs-push-2 {
                left: 16.66666667%;
            }
            .col-xs-push-1 {
                left: 8.33333333%;
            }
            .col-xs-push-0 {
                left: auto;
            }
            .col-xs-offset-12 {
                margin-left: 100%;
            }
            .col-xs-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-xs-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-xs-offset-9 {
                margin-left: 75%;
            }
            .col-xs-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-xs-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-xs-offset-6 {
                margin-left: 50%;
            }
            .col-xs-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-xs-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-xs-offset-3 {
                margin-left: 25%;
            }
            .col-xs-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-xs-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-xs-offset-0 {
                margin-left: 0;
            }
            table {
                background-color: transparent;
            }
            th {
                text-align: left;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
                text-align: center;
            }
            /* .table > tbody + tbody {
                border-top: 2px solid #ddd;
            }
            .table .table {
                background-color: #fff;
            } */

            .help-block {
                display: block;
                margin-top: 5px;
                margin-bottom: 10px;
                color: #737373;
            }

            .thumbnail {
                display: block;
                padding: 4px;
                margin-bottom: 20px;
                line-height: 1.42857143;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                -webkit-transition: border 0.2s ease-in-out;
                -o-transition: border 0.2s ease-in-out;
                transition: border 0.2s ease-in-out;
            }
            .thumbnail > img,
            .thumbnail a > img {
                margin-right: auto;
                margin-left: auto;
            }
            a.thumbnail:hover,
            a.thumbnail:focus,
            a.thumbnail.active {
                border-color: #337ab7;
            }
            .thumbnail .caption {
                padding: 9px;
                color: #333;
            }

            .clearfix:before,
            .clearfix:after,
            .container:before,
            .container:after,
            .container-fluid:before,
            .container-fluid:after,
            .row:before,
            .row:after {
                display: table;
                content: " ";
            }
            .clearfix:after,
            .container:after,
            .container-fluid:after,
            .row:after {
                clear: both;
            }
            .center-block {
                display: block;
                margin-right: auto;
                margin-left: auto;
            }
            .pull-right {
                float: right !important;
            }
            .pull-left {
                float: left !important;
            }
            @-ms-viewport {
                width: device-width;
            }

            .br-l{
                border: none;
                border-left: 1px solid #000 !important;
            }
            .br-r{
                border: none;
                border-right: 1px solid #000 !important;
            }
            .br-t{
                border: none !important;
                border-top: 1px solid #000 !important;
            }
            .br-b{
                border: none !important;
                border-bottom: 1px solid #000 !important;
            }
            .page-break {
                page-break-after: always;
            }
            *, ::after, ::before{
                box-sizing: border-box;
            }
            .row {
                /* display: flex; */
                /* -ms-flex-wrap: wrap; */
                /* flex-wrap: wrap; */
                margin-right: -7.5px;
                margin-left: -7.5px;
            }
            .col-md-4 {
                float: left;
                position: relative;
                width: 33.3%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 33.33%;
            }
            .col-md-6 {
                float: left;
                position: relative;
                width: 50%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 50%;
            }
            .col-md-12 {
                float: left;
                position: relative;
                width: 100%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 100%;
            }
            .bg-yellow{
                background-color: #f9a61d;
            }

            .tb-finance{
                width: 100%;
            }

            .tb-finance th {
                border: 1px solid #000;
                padding: 10px;
            }

            .tb-finance tr td:first-child {
                border-left: 1px solid #000;
            }

            .tb-finance tr td:last-child {
                border-right: 1px solid #000;

            }
            .tb-finance tr:last-child td {
                border-bottom: 1px solid #000;
            }
            .tb-finance td {
                padding: 2px 5px;
            }

            .tb-finance tbody{
                font-size: 10pt;
            }

            .tb-installment{
                font-size: 10pt;
                width: 100%;
                display: table;
                table-layout: fixed;
            }

            .tb-installment th{
                border: 1px solid #000;
                padding: 10px;
            }
            .tb-installment td{
                border: 1px solid #000;
                padding: 5px;
            }

            .tb-head-installment {
                margin-bottom: 15px;
            }
            .tb-head-installment tr td:first-child{
                padding-right: 10px;
                /* padding-top: 3px; */
                /* padding-bottom: 3px; */
            }
            .tb-head-installment tr td:last-child{
                padding-left: 5px;
                /* padding-top: 3px; */
                /* padding-bottom: 3px; */
            }

            .sign-box{
                height: 80px;
                width: 150px;
                border: 1px solid #000;
                margin-top:5px;
                margin-bottom:5px;
            }
            .sign-box-m{
                height: 65px;
                width: 150px;
                border: 1px solid #000;
            }

            .text-10{
                font-size: 10pt;
            }

            .mt-15{
                margin-top: 15px;
            }

            .align-top td {
                vertical-align: top;
            }

            .br-t{
                border-top: 1px solid #000;
            }
            .br-b{
                border-bottom: 1px solid #000;
            }
            .br-l{
                border-left: 1px solid #000;
            }
            .br-r{
                border-right: 1px solid #000;
            }

            .tb-sign tr td{
                padding: 25px 25px;
                width: 33.33%;
                height:200px;
                /* border:1px solid #000; */
            }

            .tb-sign tr td div:first-child{
                height: 50px;
            }
            .stamp-box{
                margin-top: 25px;
                margin-bottom: 25px;
                height: 50px;
            }
            .stamp-box-m{
                margin-top: 25px;
                margin-bottom: 25px;
                height: 30px;
            }
            .tb-bordered tr th{
                border:1px solid #000;
            }
            .tb-bordered tr td{
                border:1px solid #000;
            }

            .chapter{
                margin-bottom: 5px;
            }
            h4{
                margin-top: 10px !important;
                margin-bottom: 10px !important;
            }
            p{
                margin-top: 10px;
            }
            div>ol{
                padding-left: 15px;
            }
            li>ol{
                padding-left: 15px;
            }
            .header {
                display: table;
                width: 100%;
                height: 60px;
                margin-bottom: 15px;
            }
            .header > div {
                display: table-cell;
            }
        </style>
    </head>
    <body style="margin: 0;">
        <div>
            @include('monitoring.partial.product')
            @include('monitoring.partial.installment')
            @include('monitoring.partial.credit-agreement')
            @include('monitoring.partial.debit-procuration')
            @include('monitoring.partial.deb-statement-letter')
            @include('monitoring.partial.fund-disbursement-letter-debitur')
            @include('monitoring.partial.fund-disbursement-letter-kreditur')
            @include('monitoring.partial.statement-letter')
            @include('monitoring.partial.capability-statement-letter-debitur')
            @include('monitoring.partial.capability-statement-letter-kreditur')
            @include('monitoring.partial.submission-of-guarantee')
            @include('monitoring.partial.document-checklist')
        </div>
    </body>
</html>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            min-height: 100vh;
            background-color: #f0f4f8;
            font-family: Arial, sans-serif;
        }

        body.mirror .id-card,
        body.mirror .id-card-back {
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform-origin: center center;
        }

        .print-sheet {
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            display: grid;
            grid-template-columns: repeat(3, 54mm);
            grid-template-rows: repeat(3, 86mm);
            column-gap: 14mm;
            row-gap: 9.5mm;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
            page-break-after: always;
            break-after: page;
        }

        .print-sheet:last-child {
            page-break-after: auto;
            break-after: auto;
        }

        .card-wrap {
            width: 54mm;
            height: 86mm;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                min-height: auto;
                display: block;
                background: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body.mirror .id-card,
            body.mirror .id-card-back {
                transform: scaleX(-1);
                -webkit-transform: scaleX(-1);
            }

            .print-sheet {
                margin: 0;
                box-shadow: none;
            }

            .card-wrap {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }

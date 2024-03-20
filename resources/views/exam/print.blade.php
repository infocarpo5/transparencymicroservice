<html lang="en">
    <head>
        <meta charset="utf-8">
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <title>Invoicing report</title>

        <style>
            table {
                border-right: 0;
                width: 100%;
                border-top: 0;
                border-bottom: 0;
                border-collapse: collapse;
                font-size: 10px;
            }
           
            table th, td {
                border-right: 0.01em solid black;
                border-left: 0.01em solid black;
                border-top: 0.01em solid black;
                padding: 5px;
                border-bottom: 0.01em solid black;
            }
            .custom-button {
                padding: 0.3rem 0.2rem; /* Equivalent to px-3 py-1.5 */
                font-weight: bold; /* Equivalent to text-white */
                transition: color 0.15s ease-in-out; /* Equivalent to transition-colors duration-150 */
                background-color: #0ea5e9; /* Equivalent to bg-[#0ea5e9] */
                border: 1px solid transparent; /* Equivalent to border border-transparent */
                border-radius: 9999px; /* Equivalent to rounded-full */
                outline: none; /* Equivalent to focus:outline-none */
            }
    </style>
    </head> 
    <body onload="print()"> 

        <div style="text-align: center;">
            <b>STUDENTS EXAMINATION REPORT</b> <br>
            <b>{{ $student->class->name ?? "" }}E</b> <br>
            <b>{{ $student->name ?? "" }}</b>
        </div>
 
        <div class="flex justify-between mb-1 mt-3">
        <div class="w-full overflow-x-auto">
            @foreach($data as $semester => $results)
            <table class="w-full whitespace-no-wrap">
                <thead style="background-color: rgb(204, 134, 14);">
                    <tr>{{ $semester }} 1</tr>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2 text-center">S/N</th>
                        <th class="px-2 py-2 text-sm" align="left">Subject</th>
                        <th class="px-2 py-2 text-sm" align="left">Score</th>
                        <th class="px-2 py-2 text-sm" align="left">Grade</th>
                        <th class="px-2 py-2 text-sm text-center">Coment</th>
                    </tr>
                </thead>
                @foreach($results as $res)
                <tbody class="bg-white text-sm divide-y dark:divide-gray-700 dark:bg-gray-800">
                     <tr key="`attendance`" class="text-gray-700 dark:text-gray-400">
                         <td class="px-2 py-2 text-center text-sm" align="center">
                             {{ $res['sn'] }}
                         </td>
                         <td class="px-2 py-2 text-sm">
                             somo
                         </td>
                         <td class="px-2 py-2 text-sm">
                             {{ $res['score'] }}
                         </td>
                         <td class="px-2 py-2 text-sm text-center">
                            {{ $res['score'] > 70 ? 'A' : ($res['score'] > 60 ? 'B' : ($res['score'] > 50 ? 'C' : ($res['score'] > 40 ? 'D' : 'F'))) }}
                         </td>
                         <td class="px-2 py-2 text-sm">
                             <center> 
                                {{ $res['score'] > 70 ? 'Excellent' : ($res['score'] > 60 ? 'Very good' : ($res['score'] > 50 ? 'Good' : ($res['score'] > 40 ? 'Pass' : 'Failed'))) }}    
                            </center>
                         </td>
                     </tr>
                </tbody>
                @endforeach
            </table>
            @endforeach
        </div>
    </div>
    </body>
    </html>

    
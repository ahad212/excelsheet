<!DOCTYPE html>
<html>
 <head>
  <title>Import Excel File in Laravel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">

  <style>
      div.dataTables_wrapper div.dataTables_filter label{
          margin-right:5px;
      }
      .custom {
        margin-left:10px;
        margin-top:20px;
      }
      .fullpage{
          background:rgba(0,0,0,0.3);
          position: fixed;
          top:0;
          left:0;
          right:0;
          bottom:0;
          width:100%;
          z-index: 500;
          display: flex;
          justify-content: center;
          align-items: center;
      }
  </style>
 </head>
 <body>
    <div class="fullpage" id="fullpage">
        <img src="{{asset('excelsheet/images/loading.gif')}}" alt="">
    </div>
     <a href="{{route('logg')}}" class="btn btn-danger custom">Logout</a>
  <br />
  
  <div class="container">
   <h3 align="center">Pension File Management System, Chattogram Cantonment.</h3>
    <br />
   @if($errors->any())
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   <form method="post" enctype="multipart/form-data" action="{{ url('/excelsheet/import_excel/import') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30">
        <input type="file" name="select_file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <td width="30"><span class="text-muted">.xls, .xslx</span></td>
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>
    <button onclick="match()" class="btn btn-success" id="match">Match File</button>
    <button onclick="getunmatch()" class="btn btn-success" id="unmatch">UnMatch File</button>
   <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Customer Data</h3>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">

      </table>
      <table id="table_id" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Army</th>
                <th>Ts</th>
                <th>Army/Ts</th>
            </tr>
        </thead>
        {{-- <tbody id="body">
            @foreach($data as $row)
                <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->Segment }}</td>
                <td>{{ $row->Product }}</td>
                <td>{{ $row->extra}}</td>
                </tr>
            @endforeach
        </tbody> --}}
    </table>
    <br>
    <br>
     </div>
    </div>
   </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js" integrity="sha512-MRDODtdVPB+P6eG8RPTGDxaK55jJ8j+Iu2eJFUa+3lmeOLTrXfDbQ4ThAw7vx0iqYlAZodtE4ps23rd/NQHoXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      var loading = document.getElementById('fullpage').style.display = 'none';
      $(document).ready (function () {
            $('#table_id').DataTable({
            "ajax" : 'http://localhost/excelsheet/getdata',
            'columns' : [
                {'data' : 'id' },
                { 'data' : 'Army'},
                { 'data' : 'Ts'},
                { 'data' : 'extra'},
            ]
        });
      });
    //   window.$('#table_id').DataTable();

    let matched = document.getElementById('match');
    let unmatch = document.getElementById('unmatch');
    const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
    const EXCEL_EXTENSION = '.xlsx';
    async function match () {
        document.getElementById('fullpage').style.display = 'flex';
          const geting = await  $.get("http://localhost/excelsheet/getmatch");
          console.log(geting);
          
          const worksheet = XLSX.utils.json_to_sheet(geting);
          const workbook = {
             Sheets: {
                 'data' : worksheet
             },
             SheetNames: ['data']
         };
         const excelBuffer = XLSX.write(workbook,{bookType:'xlsx',type:'array'});
         console.log(excelBuffer);
         saveAsExcel(excelBuffer, 'Match File');
        document.getElementById('fullpage').style.display = 'none';
    }

    async function getunmatch() {
        document.getElementById('fullpage').style.display = 'flex';
        const geting = await  $.get("http://localhost/excelsheet/getunmatch");
        console.log(geting);
          
          const worksheet = XLSX.utils.json_to_sheet(geting);
          const workbook = {
             Sheets: {
                 'data' : worksheet
             },
             SheetNames: ['data']
         };
         const excelBuffer = XLSX.write(workbook,{bookType:'xlsx',type:'array'});
         console.log(excelBuffer);
         saveAsExcel(excelBuffer, 'Unmatch File');
         document.getElementById('fullpage').style.display = 'none';
        
    }

    function saveAsExcel (buffer, filname) {
        const data = new Blob([buffer],{type:EXCEL_TYPE});
        saveAs(data,filname+EXCEL_EXTENSION);
    }

    // $(document).ready( function(){
    //     $.get("http://localhost/excelsheet/getdata", function(data){
    //         console.log(data);
    //     //     let tab ='';
    //     //     let i=0;
    //     //     while(i<data.length)
    //     //     {
    //     //         tab += `<tr><td>
    //     //             `+ (i+1)+`
    //     //             </td>
    //     //             <td>
    //     //             ` + data[i].Segment+`
    //     //             </td>
    //     //             <td>
    //     //             ` + data[i].Product+`
    //     //             </td>
    //     //             <td>
    //     //             ` + data[i].extra+`
    //     //             </td>
    //     //             </tr>
    //     //         `
    //     //         i++;
    //     //     }
    //     //     document.getElementById('body').innerHTML = tab;
        
    //     });
    // });
  </script>
 </body>
</html>
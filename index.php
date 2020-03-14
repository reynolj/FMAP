<?php

$title = "FMAP | Home"; //Set the browser title
$highlight = "index"; //Select which tab in the navigation to highlight
require("structure/top.php"); //Include the sidebar HTML


?>

<html>
  <head>
    <script src="mathjs/dist/math.js" type="text/javascript"></script>
    <script src="d3/d3.js" type="text/javascript">
        import * as d3 from "/d3/d3.js";
    </script>
    <script type="text/javascript">
      let gDomain;
      let gCodomain;

      $( window ).on( "load", function() {
        document.getElementById("submit_btn").addEventListener("click", function () {
          let f_txt = document.getElementById("fx_txt").value;
          let s_txt = document.getElementById("size_txt").value;
          let size_val = parseInt(s_txt);

          if (validate_size(size_val) === true) {
            setArrays(size_val);
            // Setup modding
            f_txt = "(" + f_txt + ")" + " % " + size_val;
            calculate(f_txt);
            //popTest();
            draw(size_val);
          } else {
            //reset();
            console.log("error");
          }
        });
      });

      function draw(size_val){
        let width = document.getElementById("f_area").offsetHeight

        const svgContainer = d3.select("#svghandle")
          .append("svg")
          .attr("width","1000")
          .attr("height","720");

        const ellipses = [
          {"cx":  360, "cy":  300, "rx": 100, "ry": 40 * size_val},
          {"cx":  660, "cy":  300, "rx": 100, "ry": 40 * size_val},
        ];

        const svgEllipses = svgContainer
          .selectAll("ellipse")
          .data(ellipses)
          .enter()
          .append("ellipse")
          .style('fill', "white")
          .style("stroke", "#000000")
          .style("stroke-width", 2);

        svgEllipses
          .attr("cx", (d,i) => { return d.cx; })
          .attr("cy", (d,i) => { return d.cy; })
          .attr("rx", (d,i) => { return d.rx; })
          .attr("ry", (d,i) => { return d.ry; });

        let text = svgContainer.selectAll("text")
                      .data(ellipses)
                      .enter()
                      .append("text");

        let textLabels = text
          .attr("x", function(d) { return d.cx - 2; })
          .attr("y", function(d) { return d.cy - 150; })
          .text( function (d) { return gDomain[0]; })
          .attr("font-family", "sans-serif")
          .attr("font-size", "20px");

      }

      function reset(){
        document.getElementById("submit_btn").disable = true;
      }

      function popTest(){
        let toPrint = "";
        for( let i = 0; i < gDomain.length; i++){
            toPrint += gDomain[i] + " -> " + gCodomain[i] + "<br />" ;
        }
        document.getElementById("f_area").innerHTML = toPrint;
      }

      function validate_size(size_val){
        if ( Number.isInteger(size_val) )
        {
          if ( size_val < 5 || size_val > 10 ){
            console.log("Size: " + size_val + " not a valid integer");
            return false;
          }
            return true;
        }
        else
        {
          console.log("Size: " + size_val + " not an integer");
          return false;
        }
      }

      function setArrays(size_val){
        gDomain = Array.from(Array(size_val).keys());
        gCodomain = new Array();
      }

      function calculate(f_txt){
        // Calculate and assign mappings
        gDomain.forEach(item => {
            let scope = {x: item};
            gCodomain.push( math.evaluate(f_txt, scope) );
        })
      }

      // $(document).ready(function() {
      //     $('.formfield').on('input', function() {
      //         var nFilled = $('.formfield').filter(function() {
      //             return $.trim( this.value ) !== '';
      //         }).length;
      //         $('#loccat').prop('disabled', nFilled === 0);
      //     })
      //         .trigger('input');
      // });

    </script>
  </head>
  <body>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Function Mapping</h5>
                    </div>
                    <div class="card-body">
                        <!-- Place page content here -->
                      <div id class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">f(x)</span>
                        </div>
                        <input id = "fx_txt" type="text" class="form-control" placeholder="enter function definition here">
                      </div>
                      <div  class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Size</span>
                        </div>
                        <input id = "size_txt" type="text" class="form-control" placeholder="enter a number in range of 5-10">
                      </div>
                      <button id = "submit_btn" type="submit" class="btn btn-primary">
                        Generate Mapping
                      </button>
                      <div class="card-footer">
                          <div class="container-fluid">
                            <div class="card">
                              <div id = "f_area" class="card-body">
                                <div id = "svghandle">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


          </div><!-- /.container-fluid -->
      </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </body>
</html>
<?php include('structure/bottom.php'); ?>
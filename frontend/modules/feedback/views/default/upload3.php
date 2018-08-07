<canvas id="myCanvasImage" width="500" height="500"></canvas>

<form method="POST" name="form" id="form">
  <textarea name="base64" id="base64"></textarea>
  <button type="submit">
    Send image
  </button>
</form>

<script>

   // on the submit event, generate a image from the canvas and save the data in the textarea
   document.getElementById('form').addEventListener("submit",function(){
      var canvas = document.getElementById("myCanvasImage");
      var image = canvas.toDataURL(); // data:image/png....
      document.getElementById('base64').value = image;
   },false);

</script>

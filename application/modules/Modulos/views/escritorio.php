<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
</script>

<style type="text/css">
.containerText {
  padding: 2em;
  height: 20em;
}
.v-slider-frame {
  height: 18em;
  overflow: hidden;
  text-align: center;
}
ul.v-slides {
  list-style-type: none;
  transform: translateY(50px);
  padding:0;
}
.v-slide {
  font-size: 18px;
  line-height: 30px;
  color: #000000;
}
  
</style>

        <div class="my-3 my-md-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <form method="post" class="card">
                  <div class="card-header">
                    <h3 class="card-title"><h3 class="card-title"><?php echo $titulo; ?></h3></h3>
                  </div>
                  <div class="card-body">

                      
<div class="containerText">
  <div class="row">
    <div class="v-slider-frame col-sm-12 offset-sm-12">
      <ul class="v-slides">
        <li class="v-slide"><h3>Unidad: Grupo de Sistemas Informáticos, Comunicaciones y Guerra Electrónica Conjunto</h3></li>
        <hr>
        <li class="v-slide"><strong>Misión.- </strong>Instalar, explotar y mantener los Sistemas de comunicaciones, informáticos y de guerra electrónica del Comando Conjunto de las Fuerzas Armadas, mediante el empleo de las redes de comunicaciones, plataforma informática y control de las emisiones radio eléctrica, para proveer al mando militar, los medios y servicios tecnológicos para contribuir a la defensa de la soberanía, integridad territorial y desarrollo nacional.</li>
        <hr>
        <li class="v-slide"><h3>GESTIÓN COMUNICACIONES</h3></li>
        <hr>
        <li class="v-slide"><strong>PROPÓSITO:</strong> Asesorar, planificar, implementar, gestionar y mantener los sistemas y servicios de telecomunicaciones de la red estratégica de Fuerzas Armadas con estándares internacionales, en forma permanente y a nivel nacional, a fin de apoyar al cumplimiento de la misión de la Dirección.</li>
      </ul>
    </div>
  </div>
</div>


                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js'></script>

<script type="text/javascript">
  
var vsOpts = {
  $slides: $('.v-slide'),
  $list: $('.v-slides'),
  duration: 20,
  lineHeight: 60
}

var vSlide = new TimelineMax({
  paused: true,
  repeat: -1
})

vsOpts.$slides.each(function(i) {
  vSlide.to(vsOpts.$list, vsOpts.duration / vsOpts.$slides.length, {
    y: i * -1 * vsOpts.lineHeight,
    ease: Elastic.easeOut.config(1, 0.4)
  })
})
vSlide.play()

</script>
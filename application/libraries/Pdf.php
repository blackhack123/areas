<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";

    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones



    class Pdf extends FPDF {

        var $angulo=0;

        function Rotar($angulo,$x=-1,$y=-1){
          if($x==-1)
            $x=$this->x;
          if($y==-1)
            $y=$this->y;
          if($this->angulo!=0)
            $this->_out('Q');
            $this->angulo=$angulo;
          if($angulo!=0)
            {
            $angulo*=M_PI/180;
            $c=cos($angulo);
            $s=sin($angulo);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
            }
        }

    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
    
        function _endpage(){
          if($this->angulo!=0){
            $this->angulo=0;
            $this->_out('Q');
          }
          parent::_endpage();
        }


          public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
            //$this->Image('imagenes/logo.png',10,8,22);
            //$this->load->model('institucion');
            //$datosInstitucion = datosInstitucion();
            //$this->SetFont('Arial','B',13);
            //$this->Cell(30);
            //$this->Cell(120,10,$data,0,0,'C');
            //$this->Ln('5');
            //$this->SetFont('Arial','B',8);
            //$this->Cell(30);
            //$this->Cell(120,10,'INFORMACION DE CONTACTO',0,0,'C');
            //$this->Ln(20);
       }
       // El pie del pdf
       public function Footer(){
           //$this->SetY(-15);
           //$this->SetFont('Arial','I',8);
           //$this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
      }

        function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
        {
            $k=$this->k;
            if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
            {
                $x=$this->x;
                $ws=$this->ws;
                if($ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $this->AddPage($this->CurOrientation);
                $this->x=$x;
                if($ws>0)
                {
                    $this->ws=$ws;
                    $this->_out(sprintf('%.3F Tw', $ws*$k));
                }
            }
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $s='';
            if($fill || $border==1)
            {
                if($fill)
                    $op=($border==1) ? 'B' : 'f';
                else
                    $op='S';
                $s=sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x*$k, ($this->h-$this->y)*$k, $w*$k, -$h*$k, $op);
            }
            if(is_string($border))
            {
                $x=$this->x;
                $y=$this->y;
                if(is_int(strpos($border, 'L')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ', $x*$k, ($this->h-$y)*$k, $x*$k, ($this->h-($y+$h))*$k);
                if(is_int(strpos($border, 'T')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ', $x*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-$y)*$k);
                if(is_int(strpos($border, 'R')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ', ($x+$w)*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
                if(is_int(strpos($border, 'B')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ', $x*$k, ($this->h-($y+$h))*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
            }
            if($txt!='')
            {
                if($align=='R')
                    $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
                elseif($align=='C')
                    $dx=($w-$this->GetStringWidth($txt))/2;
                elseif($align=='FJ')
                {
                    //Set word spacing
                    $wmax=($w-2*$this->cMargin);
                    $this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt, ' ');
                    $this->_out(sprintf('%.3F Tw', $this->ws*$this->k));
                    $dx=$this->cMargin;
                }
                else
                    $dx=$this->cMargin;
                $txt=str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if($this->ColorFlag)
                    $s.='q '.$this->TextColor.' ';
                $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x+$dx)*$k, ($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k, $txt);
                if($this->underline)
                    $s.=' '.$this->_dounderline($this->x+$dx, $this->y+.5*$h+.3*$this->FontSize, $txt);
                if($this->ColorFlag)
                    $s.=' Q';
                if($link)
                {
                    if($align=='FJ')
                        $wlink=$wmax;
                    else
                        $wlink=$this->GetStringWidth($txt);
                    $this->Link($this->x+$dx, $this->y+.5*$h-.5*$this->FontSize, $wlink, $this->FontSize, $link);
                }
            }
            if($s)
                $this->_out($s);
            if($align=='FJ')
            {
                //Remove word spacing
                $this->_out('0 Tw');
                $this->ws=0;
            }
            $this->lasth=$h;
            if($ln>0)
            {
                $this->y+=$h;
                if($ln==1)
                    $this->x=$this->lMargin;
            }
            else
                $this->x+=$w;
        }
                
    }
?>
<style>
    .ulprofiler{
        font-size: 9px;
        color: #003399;
    }
    .h6profiler{
        color: #003399;
    }
    .contentProfiler{
        border :1px dotted #003399;
        padding:2px;
        margin:2px;
        width:20%;
        margin-left:75%;
        position: fixed;
        background: #fff;
    }
  
    
    
</style>
<div class='contentProfiler'>
    <h6 class="h6profiler">Profiler</h6>
    <p>
    <ol class="ulprofiler">
        <li>Memoria usada = <?php echo memory_get_usage()/1024; ?>  Kbytes;</li>
    </ol>
    </p>
</div>



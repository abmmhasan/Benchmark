<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use JsonException;

/** Generates a dependency-free browser dashboard for one archived benchmark run. */
final class BenchmarkDashboard
{
    /** @param array<string, mixed> $payload */
    public static function render(array $payload): string
    {
        try {
            $json = json_encode(
                $payload,
                JSON_THROW_ON_ERROR
                | JSON_UNESCAPED_SLASHES
                | JSON_HEX_TAG
                | JSON_HEX_AMP
                | JSON_HEX_APOS
                | JSON_HEX_QUOT,
            );
        } catch (JsonException) {
            $json = '{}';
        }

        return str_replace('__BENCHMARK_DATA__', $json, <<<'HTML'
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PHP framework benchmark</title>
<style>
:root{color-scheme:dark;--bg:#08111f;--panel:#101c2f;--line:#263750;--text:#e7eef9;--muted:#91a4bd;--accent:#38bdf8;--good:#34d399;--bad:#fb7185}
*{box-sizing:border-box}body{margin:0;background:linear-gradient(135deg,#08111f,#101827);color:var(--text);font:14px/1.5 ui-sans-serif,system-ui,sans-serif}
main{max-width:1400px;margin:auto;padding:28px}h1{font-size:28px;margin:0}h2{font-size:17px;margin:0 0 16px}.muted{color:var(--muted)}
.header{display:flex;justify-content:space-between;gap:20px;align-items:end;margin-bottom:24px}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
.panel{background:rgba(16,28,47,.92);border:1px solid var(--line);border-radius:14px;padding:18px;box-shadow:0 18px 40px #0003}.wide{grid-column:1/-1}
canvas{width:100%;height:320px;display:block}table{width:100%;border-collapse:collapse}th,td{padding:10px 12px;border-bottom:1px solid var(--line);text-align:right}th:first-child,td:first-child{text-align:left}th{color:var(--muted);font-weight:600}.ok{color:var(--good)}.warn{color:var(--bad)}
@media(max-width:850px){.grid{grid-template-columns:1fr}.header{align-items:start;flex-direction:column}main{padding:18px}.panel{overflow:auto}}
</style>
</head>
<body><main>
<div class="header"><div><h1>PHP framework benchmark</h1><div class="muted" id="subtitle"></div></div><div class="muted">php-curl-multi · validated responses</div></div>
<div class="grid">
  <section class="panel"><h2>Peak observed requests/minute</h2><canvas id="rpm"></canvas></section>
  <section class="panel"><h2>Successful-response p99 latency (ms)</h2><canvas id="latency"></canvas></section>
  <section class="panel"><h2>Remote peak memory (MB)</h2><canvas id="memory"></canvas></section>
  <section class="panel"><h2>Server execution time (ms)</h2><canvas id="execution"></canvas></section>
  <section class="panel wide"><h2>Results</h2><table><thead><tr><th>Target</th><th>Stable RPM</th><th>Peak RPM</th><th>Concurrency</th><th>p50 ms</th><th>p99 ms</th><th>Error</th><th>Memory MB</th><th>Included files</th></tr></thead><tbody id="results"></tbody></table></section>
</div>
</main>
<script>
const payload=__BENCHMARK_DATA__;
const results=payload.results||payload;
const entries=Object.entries(results).map(([name,r])=>({name,r}));
document.getElementById('subtitle').textContent=(payload.recordedAt||'')+' · '+entries.length+' targets';
const number=(v,d=0)=>v==null?'—':Number(v).toLocaleString(undefined,{maximumFractionDigits:d,minimumFractionDigits:d});
const metric=(r,name)=>r.remoteMetrics&&r.remoteMetrics[name]?r.remoteMetrics[name].average:null;
const rows=document.getElementById('results');
entries.sort((a,b)=>(a.r.rank??9999)-(b.r.rank??9999)||b.r.peak.req_per_min-a.r.peak.req_per_min).forEach(({name,r})=>{
 const tr=document.createElement('tr');const error=(r.multiple.error_rate||0)*100;
 const values=[name,number(r.stable&&r.stable.req_per_min),number(r.peak.req_per_min),number(r.peak.concurrency),number((r.multiple.p50??0)*1000,2),number((r.multiple.p99??0)*1000,2),number(error,2)+'%',number(r.remoteMemoryMB,2),number(metric(r,'included_files'))];
 values.forEach((value,i)=>{const td=document.createElement('td');td.textContent=value;if(i===6)td.className=error===0?'ok':'warn';tr.appendChild(td)});rows.appendChild(tr)
});
function chart(id,label,value,color){
 const canvas=document.getElementById(id),ctx=canvas.getContext('2d'),ratio=devicePixelRatio||1,w=canvas.clientWidth,h=canvas.clientHeight;canvas.width=w*ratio;canvas.height=h*ratio;ctx.scale(ratio,ratio);ctx.clearRect(0,0,w,h);
 const data=entries.map(x=>({name:x.name,value:Number(value(x.r)||0)}));const max=Math.max(1,...data.map(x=>x.value));const gap=8,bar=Math.max(8,(w-70)/Math.max(1,data.length)-gap),base=h-55;
 ctx.font='12px system-ui';ctx.textAlign='center';data.forEach((x,i)=>{const px=55+i*(bar+gap),bh=(base-28)*(x.value/max);ctx.fillStyle=color;ctx.fillRect(px,base-bh,bar,bh);ctx.fillStyle='#e7eef9';ctx.fillText(number(x.value,x.value<100?2:0),px+bar/2,base-bh-7);ctx.save();ctx.translate(px+bar/2,base+9);ctx.rotate(-Math.PI/5);ctx.fillStyle='#91a4bd';ctx.textAlign='right';ctx.fillText(x.name,0,0);ctx.restore()});
 ctx.strokeStyle='#263750';ctx.beginPath();ctx.moveTo(45,base);ctx.lineTo(w-5,base);ctx.stroke();
}
chart('rpm','RPM',r=>r.peak.req_per_min,'#38bdf8');chart('latency','p99',r=>(r.multiple.p99||0)*1000,'#fb7185');chart('memory','MB',r=>r.remoteMemoryMB,'#34d399');chart('execution','ms',r=>metric(r,'server_execution_ms'),'#fbbf24');
</script></body></html>
HTML);
    }
}

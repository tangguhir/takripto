<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semalock — Verifikasi Hak Cipta Gambar Digital</title>
<link rel="icon" type="image/png" href="/favicon.ico">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style nonce="{{ $cspNonce }}">
  :root{
    --bg:#07090d;
    --bg2:#0c1018;
    --bg3:#121826;
    --panel:#0f141e;
    --panel2:#151c2a;
    --line:#1f2738;
    --line2:#2a3348;
    --text:#e8ecf3;
    --muted:#9aa4b8;
    --faint:#6b7488;
    --accent:#4f7cff;
    --accent-hover:#6b8fff;
    --accent-soft:rgba(79,124,255,.12);
    --danger:#ff5a6b;
    --ok:#34d399;
    --warn:#f5b041;
    --mono:ui-monospace,SFMono-Regular,Menlo,Consolas,"Liberation Mono",monospace;
    --sans:"Plus Jakarta Sans",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  }
  *{box-sizing:border-box}
  html,body{margin:0;padding:0;background:var(--bg);color:var(--text);font-family:var(--sans);font-size:15px;line-height:1.6;-webkit-font-smoothing:antialiased}
  body{min-height:100vh;overflow-x:hidden}
  body::before{content:"";position:fixed;inset:0;z-index:-2;background:
    radial-gradient(1200px 600px at 80% -10%,rgba(79,124,255,.18),transparent 60%),
    radial-gradient(900px 500px at -10% 110%,rgba(52,211,153,.08),transparent 60%),
    var(--bg)}
  a{color:var(--accent);text-decoration:none}
  a:hover{text-decoration:underline}
  .wrap{max-width:1120px;margin:0 auto;padding:0 28px}
  /* topbar */
  .topbar{position:sticky;top:0;z-index:50;backdrop-filter:blur(12px);background:rgba(7,9,13,.72);border-bottom:1px solid var(--line)}
  .topbar .wrap{display:flex;align-items:center;justify-content:space-between;height:64px}
  .brand{display:flex;align-items:center;gap:10px;font-weight:700;letter-spacing:-.01em}
  .brand .mark{width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#4f7cff,#7c5cff);display:grid;place-items:center;color:#fff;font-size:14px;font-weight:800}
  .nav{display:flex;gap:6px;align-items:center}
  .nav a{padding:8px 12px;border-radius:8px;color:var(--muted);font-weight:500;font-size:14px}
  .nav a:hover{color:var(--text);background:var(--panel)}
  .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:10px;border:1px solid var(--line2);background:var(--panel);color:var(--text);font-weight:600;font-size:14px;cursor:pointer;transition:.15s}
  .btn:hover{border-color:var(--accent);color:var(--accent)}
  .btn.primary{background:var(--accent);border-color:var(--accent);color:#fff}
  .btn.primary:hover{background:var(--accent-hover);border-color:var(--accent-hover)}
  .btn.ghost{background:transparent}
  /* hero */
  .hero{padding:56px 0 32px}
  .hero h1{font-size:clamp(30px,4.2vw,46px);line-height:1.1;letter-spacing:-.02em;margin:0 0 14px;font-weight:800}
  .hero h1 .grad{background:linear-gradient(120deg,#4f7cff 0%,#7c5cff 60%,#34d399 100%);-webkit-background-clip:text;background-clip:text;color:transparent}
  .hero p{color:var(--muted);font-size:16px;max-width:720px;margin:0}
  .pill{display:inline-flex;align-items:center;gap:8px;padding:6px 12px;border-radius:999px;background:var(--accent-soft);border:1px solid rgba(79,124,255,.25);color:var(--accent);font-size:12px;font-weight:600;margin-bottom:14px}
  /* cards */
  .section{padding:24px 0 60px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
  .card{background:linear-gradient(180deg,var(--panel),var(--panel2));border:1px solid var(--line);border-radius:16px;padding:22px}
  .card h3{margin:0 0 6px;font-size:16px;font-weight:700}
  .card .sub{color:var(--muted);font-size:13px;margin:0 0 16px}
  .field{margin-bottom:14px}
  .field label{display:block;font-size:13px;font-weight:600;color:var(--muted);margin-bottom:6px}
  .field input,.field textarea,.field select{width:100%;padding:10px 12px;border-radius:10px;border:1px solid var(--line2);background:var(--bg3);color:var(--text);font-family:var(--sans);font-size:14px;outline:none;transition:.15s}
  .field input:focus,.field textarea:focus,.field select:focus{border-color:var(--accent)}
  .field textarea{min-height:80px;resize:vertical}
  .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
  .drop{border:2px dashed var(--line2);border-radius:12px;padding:18px;text-align:center;color:var(--muted);cursor:pointer;background:var(--bg3);transition:.15s}
  .drop:hover,.drop.over{border-color:var(--accent);color:var(--text);background:var(--accent-soft)}
  .drop .hint{font-size:12px;color:var(--faint);margin-top:6px}
  .preview{margin-top:12px;border:1px solid var(--line);border-radius:10px;overflow:hidden;background:var(--bg3);display:grid;place-items:center;min-height:120px}
  .preview img{max-width:100%;max-height:260px;display:block}
  .mono{font-family:var(--mono);font-size:12px;color:var(--muted);word-break:break-all}
  .status{padding:10px 12px;border-radius:10px;border:1px solid var(--line);background:var(--bg3);font-size:13px;margin-top:12px}
  .status.ok{border-color:rgba(52,211,153,.4);color:var(--ok)}
  .status.err{border-color:rgba(255,90,107,.4);color:var(--danger)}
  .status.warn{border-color:rgba(245,176,65,.4);color:var(--warn)}
  .tabs{display:flex;gap:6px;margin-bottom:14px}
  .tab{padding:8px 14px;border-radius:8px;border:1px solid var(--line);background:transparent;color:var(--muted);cursor:pointer;font-weight:600;font-size:13px}
  .tab.active{background:var(--accent);border-color:var(--accent);color:#fff}
  .metric{display:grid;grid-template-columns:auto 1fr;gap:10px;padding:8px 0;border-bottom:1px solid var(--line);font-size:13px}
  .metric:last-child{border-bottom:none}
  .metric .k{color:var(--faint);font-weight:600}
  .metric .v{color:var(--text)}
  .foot{padding:32px 0 40px;color:var(--faint);font-size:13px;border-top:1px solid var(--line);margin-top:20px}
  .pass-wrap{position:relative}
  .pass-wrap input{padding-right:42px}
  .toggle-pass{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:transparent;border:none;color:var(--muted);cursor:pointer;padding:4px;display:inline-flex;align-items:center;justify-content:center;border-radius:6px}
  .toggle-pass:hover{color:var(--text);background:var(--panel)}
  .toggle-pass svg{width:18px;height:18px;display:block}
  @media (max-width:860px){.grid{grid-template-columns:1fr}.hero{padding:40px 0 20px}}
</style>
</head>
<body>
<header class="topbar">
  <div class="wrap">
    <div class="brand">Semalock</div>
    <nav class="nav">
      <a href="/">Home</a>
    </nav>
  </div>
</header>

<section class="hero">
  <div class="wrap">
    <span class="pill">Watermark QR · AES-256-GCM · Client-side</span>
    <h1>Verifikasi hak cipta gambar digital <span class="grad">dengan watermark terenkripsi</span></h1>
    <p> Semua proses (enkripsi, QR, embedding LSB) dilakukan di browser. Tidak ada gambar atau passphrase yang dikirim ke server. </p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="tabs">
      <button class="tab active" data-tab="embed">Embed Watermark</button>
      <button class="tab" data-tab="verify">Verifikasi</button>
    </div>

    <!-- EMBED -->
    <div class="tabpane" id="pane-embed">
      <div class="grid">
        <div class="card">
          <h3>Gambar asli (PNG/JPG)</h3>
          <p class="sub">PNG keluaran selalu PNG agar kanal LSB stabil.</p>
          <div class="drop" id="dropEmbed">Seret & lepas gambar di sini, atau klik
            <div class="hint">Maks ~8 MP, format PNG/JPG/WebP</div>
          </div>
          <input type="file" id="fileEmbed" accept="image/*" hidden>
          <div class="preview" id="previewEmbed"><span class="mono">Belum ada gambar</span></div>
        </div>
        <div class="card">
          <h3>Data kepemilikan</h3>
          <p class="sub">Isi minimal. Hindari data pribadi berlebihan.</p>
          <div class="field"><label>Nama pencipta</label><input id="creator" placeholder="Nama lengkap"></div>
          <div class="field"><label>Judul karya</label><input id="title" placeholder="Judul gambar"></div>
          <div class="field"><label>Tahun</label><input id="year" placeholder="2025" value="2025"></div>
          <div class="field"><label>ID / lisensi (opsional)</label><input id="license" placeholder="CC-BY / Nomor registrasi"></div>
          <div class="field"><label for="passEmbed">Passphrase</label>
            <div class="pass-wrap">
              <input id="passEmbed" type="password" placeholder="Kunci rahasia" autocomplete="new-password">
              <button type="button" class="toggle-pass" data-target="passEmbed" aria-label="Tampilkan passphrase" title="Tampilkan/sembunyikan passphrase">
                <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-5.94"></path><path d="M9.9 4.24A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a21.74 21.74 0 0 1-3.17 4.51"></path><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
              </button>
            </div>
          </div>
          <div class="field"><label>Iterasi PBKDF2</label><input id="iters" type="number" value="210000" min="100000" step="10000"></div>
          <div class="row">
            <button class="btn primary" id="btnEmbed">Embed & Unduh PNG</button>
            <button class="btn" id="btnQr">Tampilkan QR</button>
          </div>
          <div id="statusEmbed" class="status" style="display:none"></div>
        </div>
      </div>
      <div class="card" style="margin-top:18px">
        <h3>Hasil & metrik</h3>
        <p class="sub">Kapasitas, ukuran QR, dan kualitas (PSNR/MSE).</p>
        <div id="metricsEmbed"></div>
        <div class="preview" id="qrPreview" style="min-height:160px"><span class="mono">QR akan muncul di sini</span></div>
      </div>
    </div>

    <!-- VERIFY -->
    <div class="tabpane" id="pane-verify" style="display:none">
      <div class="grid">
        <div class="card">
          <h3>Gambar ter-watermark (PNG)</h3>
          <p class="sub">Unggah PNG yang dihasilkan Semalock.</p>
          <div class="drop" id="dropVerify">Seret & lepas gambar di sini, atau klik
            <div class="hint">Harus PNG dengan watermark Semalock</div>
          </div>
          <input type="file" id="fileVerify" accept="image/png" hidden>
          <div class="preview" id="previewVerify"><span class="mono">Belum ada gambar</span></div>
        </div>
        <div class="card">
          <h3>Verifikasi</h3>
          <p class="sub">Masukkan passphrase yang sama.</p>
          <div class="field"><label for="passVerify">Passphrase</label>
            <div class="pass-wrap">
              <input id="passVerify" type="password" placeholder="Kunci rahasia" autocomplete="current-password">
              <button type="button" class="toggle-pass" data-target="passVerify" aria-label="Tampilkan passphrase" title="Tampilkan/sembunyikan passphrase">
                <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-5.94"></path><path d="M9.9 4.24A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a21.74 21.74 0 0 1-3.17 4.51"></path><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
              </button>
            </div>
          </div>
          <div class="row">
            <button class="btn primary" id="btnVerify">Verifikasi</button>
          </div>
          <div id="statusVerify" class="status" style="display:none"></div>
          <div id="metricsVerify" style="margin-top:12px"></div>
          <div class="field" style="margin-top:12px">
            <label>QR Terekstrak</label>
            <div class="preview" id="qrPreviewVerify" style="min-height:160px"><span class="mono">QR hasil ekstraksi akan muncul di sini</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="foot">
  <div class="wrap">Semalock — alat bantu verifikasi informasi kepemilikan. Pembuktian hukum memerlukan bukti tambahan.</div>
</footer>

<!-- qrcode lib -->
<script nonce="{{ $cspNonce }}" src="/semalock/qrcode-generator.js"></script>
<script nonce="{{ $cspNonce }}" src="/semalock/jsQR.js"></script>
<script nonce="{{ $cspNonce }}">
(function(){
  const $ = (s, r=document) => r.querySelector(s);
  const $$ = (s, r=document) => Array.from(r.querySelectorAll(s));

  // ---------- helpers ----------
  const te = new TextEncoder();
  const td = new TextDecoder();
  function b64u(buf){ return btoa(String.fromCharCode(...new Uint8Array(buf))).replace(/\+/g,'-').replace(/\//g,'_').replace(/=+$/,''); }
  function unb64u(s){ s=s.replace(/-/g,'+').replace(/_/g,'/'); while(s.length%4) s+='='; const b=atob(s); const a=new Uint8Array(b.length); for(let i=0;i<b.length;i++) a[i]=b.charCodeAt(i); return a; }
  async function deriveKey(pass, salt, iters){
    const base = await crypto.subtle.importKey('raw', te.encode(pass), 'PBKDF2', false, ['deriveKey']);
    return crypto.subtle.deriveKey({name:'PBKDF2',salt,iterations:iters,hash:'SHA-256'}, base, {name:'AES-GCM',length:256}, false, ['encrypt','decrypt']);
  }
  function magic(){ return [0x53,0x45,0x4d,0x41]; } // SEMA
  const VERSION = 1;

  // ---------- tabs ----------
  $$('.tab').forEach(t=>t.addEventListener('click',()=>{
    $$('.tab').forEach(x=>x.classList.remove('active'));
    t.classList.add('active');
    const name=t.dataset.tab;
    $('#pane-embed').style.display = name==='embed'?'':'none';
    $('#pane-verify').style.display = name==='verify'?'':'none';
  }));

  // ---------- file drop ----------
  function bindDrop(dropSel, inputSel, previewSel, onFile){
    const drop=$(dropSel), input=$(inputSel), preview=$(previewSel);
    drop.addEventListener('click',()=>input.click());
    drop.addEventListener('dragover',e=>{e.preventDefault();drop.classList.add('over');});
    drop.addEventListener('dragleave',()=>drop.classList.remove('over'));
    drop.addEventListener('drop',e=>{e.preventDefault();drop.classList.remove('over'); if(e.dataTransfer.files[0]) handle(e.dataTransfer.files[0]);});
    input.addEventListener('change',()=>{ if(input.files[0]) handle(input.files[0]); });
    function handle(f){
      const r=new FileReader();
      r.onload=()=>{ const img=new Image(); img.onload=()=>{ onFile(f,img); }; img.src=r.result; };
      r.readAsDataURL(f);
      preview.innerHTML='<img src="" alt="">';
      if(inputSel==='#fileEmbed'){ hideStatus($('#statusEmbed')); }
      if(inputSel==='#fileVerify'){ hideStatus($('#statusVerify')); const mv=$('#metricsVerify'); if(mv) mv.innerHTML=''; const qv=$('#qrPreviewVerify'); if(qv) qv.innerHTML='<span class="mono">QR hasil ekstraksi akan muncul di sini</span>'; }
    }
  }

  let embedImg=null, embedFile=null;
  bindDrop('#dropEmbed','#fileEmbed','#previewEmbed',(f,img)=>{
    embedFile=f; embedImg=img;
    const p=$('#previewEmbed'); p.innerHTML=''; const i=document.createElement('img'); i.src=img.src; p.appendChild(i);
  });
  let verifyImg=null, verifyFile=null;
  bindDrop('#dropVerify','#fileVerify','#previewVerify',(f,img)=>{
    verifyFile=f; verifyImg=img;
    const p=$('#previewVerify'); p.innerHTML=''; const i=document.createElement('img'); i.src=img.src; p.appendChild(i);
  });

  function showStatus(el,msg,type){ el.style.display='block'; el.textContent=msg; el.className='status '+ (type||''); }
  function hideStatus(el){ if(!el) return; el.style.display='none'; el.textContent=''; el.className='status'; }

  // toggle show/hide passphrase
  $$('.toggle-pass').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const input=document.getElementById(btn.dataset.target);
      if(!input) return;
      const show=input.type==='password';
      input.type=show?'text':'password';
      btn.setAttribute('aria-label', show?'Sembunyikan passphrase':'Tampilkan passphrase');
      const eye=btn.querySelector('.icon-eye');
      const eyeOff=btn.querySelector('.icon-eye-off');
      if(eye&&eyeOff){ eye.style.display=show?'none':'block'; eyeOff.style.display=show?'block':'none'; }
      input.focus({preventScroll:true});
    });
  });

  // hide notifications on user interaction so re-submit shows fresh
  function bindAutoHide(containerSel, statusEl, extraClear){
    const c=$(containerSel); if(!c||!statusEl) return;
    c.addEventListener('input',()=>{ hideStatus(statusEl); if(extraClear) extraClear(); });
    c.addEventListener('change',()=>{ hideStatus(statusEl); if(extraClear) extraClear(); });
  }
  bindAutoHide('#pane-embed', $('#statusEmbed'));
  bindAutoHide('#pane-verify', $('#statusVerify'), ()=>{ const mv=$('#metricsVerify'); if(mv) mv.innerHTML=''; const qv=$('#qrPreviewVerify'); if(qv) qv.innerHTML='<span class="mono">QR hasil ekstraksi akan muncul di sini</span>'; });

  // ---------- embed ----------
  $('#btnEmbed').addEventListener('click', async ()=>{
    hideStatus($('#statusEmbed'));
    if(!embedImg){ showStatus($('#statusEmbed'),'Pilih gambar terlebih dahulu.','err'); return; }
    const creator=$('#creator').value.trim();
    const title=$('#title').value.trim();
    const year=$('#year').value.trim();
    const license=$('#license').value.trim();
    const pass=$('#passEmbed').value;
    if(!creator||!title||!pass){ showStatus($('#statusEmbed'),'Nama, judul, dan passphrase wajib diisi.','err'); return; }
    const iters=parseInt($('#iters').value,10)||210000;
    const payload={v:1,creator,title,year,license,created:new Date().toISOString()};
    const pt=te.encode(JSON.stringify(payload));
    const salt=crypto.getRandomValues(new Uint8Array(16));
    const iv=crypto.getRandomValues(new Uint8Array(12));
    const key=await deriveKey(pass,salt,iters);
    const ct=await crypto.subtle.encrypt({name:'AES-GCM',iv}, key, pt);
    const ctArr=new Uint8Array(ct);
    // envelope binary: magic(4) version(1) iters(4) saltLen(1) salt saltLen ivLen(1) iv ivLen ctLen(4) ct
    const env=new Uint8Array(4+1+4+1+salt.length+1+iv.length+4+ctArr.length);
    let o=0;
    env.set(magic(),o); o+=4;
    env[o++]=VERSION;
    const dv=new DataView(env.buffer);
    dv.setUint32(o,iters,true); o+=4;
    env[o++]=salt.length; env.set(salt,o); o+=salt.length;
    env[o++]=iv.length; env.set(iv,o); o+=iv.length;
    dv.setUint32(o,ctArr.length,true); o+=4;
    env.set(ctArr,o); o+=ctArr.length;
    const b64=b64u(env.buffer);
    // generate QR
    const qr=qrcode(0,'M');
    qr.addData(b64);
    qr.make();
    const mod=qr.getModuleCount();
    const qrBits=[];
    for(let r=0;r<mod;r++) for(let c=0;c<mod;c++) qrBits.push(qr.isDark(r,c)?1:0);
    // LSB embed into image
    const canvas=document.createElement('canvas');
    canvas.width=embedImg.naturalWidth; canvas.height=embedImg.naturalHeight;
    const ctx=canvas.getContext('2d');
    ctx.drawImage(embedImg,0,0);
    const imgd=ctx.getImageData(0,0,canvas.width,canvas.height);
    const data=imgd.data;
    const pxCount=canvas.width*canvas.height;
    // header: magic(4) version(1) mod(2) bitsLen(4) = 11 bytes -> 88 bits, MSB-first per byte
    function pushByteBits(arr, byte){ for(let b=7;b>=0;b--) arr.push((byte>>b)&1); }
    const headerBits=[];
    for(const b of magic()) pushByteBits(headerBits,b);
    pushByteBits(headerBits, VERSION);
    pushByteBits(headerBits, (mod>>8)&255);
    pushByteBits(headerBits, mod&255);
    pushByteBits(headerBits, (qrBits.length>>24)&255);
    pushByteBits(headerBits, (qrBits.length>>16)&255);
    pushByteBits(headerBits, (qrBits.length>>8)&255);
    pushByteBits(headerBits, qrBits.length&255);
    const allBits = headerBits.concat(qrBits);
    // pack bits into channel LSBs RGB
    const cap=pxCount*3;
    if(allBits.length>cap){ showStatus($('#statusEmbed'),'Gambar terlalu kecil untuk watermark ini.','err'); return; }
    let idx=0;
    for(let i=0;i<data.length && idx<allBits.length;i+=4){
      for(let ch=0;ch<3 && idx<allBits.length;ch++){
        data[i+ch]=(data[i+ch]&0xFE)|allBits[idx++];
      }
    }
    ctx.putImageData(imgd,0,0);
    // PSNR / MSE vs original
    const orig=document.createElement('canvas'); orig.width=canvas.width; orig.height=canvas.height;
    const octx=orig.getContext('2d'); octx.drawImage(embedImg,0,0);
    const od=octx.getImageData(0,0,canvas.width,canvas.height).data;
    let sse=0,n=0;
    for(let i=0;i<data.length;i+=4){ for(let ch=0;ch<3;ch++){ const d=data[i+ch]-od[i+ch]; sse+=d*d; n++; } }
    const mse=sse/n; const psnr= mse===0?Infinity:10*Math.log10(255*255/mse);
    // download
    const a=document.createElement('a');
    a.href=canvas.toDataURL('image/png');
    a.download='semalock_'+(title.replace(/\s+/g,'_'))+'.png';
    a.click();
    // metrics
    $('#metricsEmbed').innerHTML=
      metric('Dimensi',canvas.width+'×'+canvas.height)+
      metric('Modul QR',mod+'×'+mod)+
      metric('Bit tertanam',allBits.length+' / '+cap)+
      metric('PSNR', (isFinite(psnr)?psnr.toFixed(2):'∞')+' dB')+
      metric('MSE', mse.toFixed(4));
    // QR preview
    const qrcanvas=document.createElement('canvas');
    const qctx=qrcanvas.getContext('2d');
    const scale=Math.max(2,Math.floor(240/mod));
    qrcanvas.width=mod*scale; qrcanvas.height=mod*scale;
    for(let r=0;r<mod;r++) for(let c=0;c<mod;c++){
      qctx.fillStyle=qr.isDark(r,c)?'#000':'#fff';
      qctx.fillRect(c*scale,r*scale,scale,scale);
    }
    const qp=$('#qrPreview'); qp.innerHTML=''; qp.appendChild(qrcanvas);
    showStatus($('#statusEmbed'),'Watermark berhasil ditanam. File PNG diunduh.','ok');
  });

  // ---------- show QR without embedding ----------
  $('#btnQr').addEventListener('click', async ()=>{
    hideStatus($('#statusEmbed'));
    const creator=$('#creator').value.trim();
    const title=$('#title').value.trim();
    const year=$('#year').value.trim();
    const license=$('#license').value.trim();
    const pass=$('#passEmbed').value;
    if(!creator||!title||!pass){ showStatus($('#statusEmbed'),'Nama, judul, dan passphrase wajib diisi.','err'); return; }
    const iters=parseInt($('#iters').value,10)||210000;
    try{
      const payload={v:1,creator,title,year,license,created:new Date().toISOString()};
      const pt=te.encode(JSON.stringify(payload));
      const salt=crypto.getRandomValues(new Uint8Array(16));
      const iv=crypto.getRandomValues(new Uint8Array(12));
      const key=await deriveKey(pass,salt,iters);
      const ct=await crypto.subtle.encrypt({name:'AES-GCM',iv}, key, pt);
      const ctArr=new Uint8Array(ct);
      const env=new Uint8Array(4+1+4+1+salt.length+1+iv.length+4+ctArr.length);
      let o=0;
      env.set(magic(),o); o+=4;
      env[o++]=VERSION;
      const dv=new DataView(env.buffer);
      dv.setUint32(o,iters,true); o+=4;
      env[o++]=salt.length; env.set(salt,o); o+=salt.length;
      env[o++]=iv.length; env.set(iv,o); o+=iv.length;
      dv.setUint32(o,ctArr.length,true); o+=4;
      env.set(ctArr,o);
      const b64=b64u(env.buffer);
      const qr=qrcode(0,'M');
      qr.addData(b64);
      qr.make();
      const mod=qr.getModuleCount();
      const qrcanvas=document.createElement('canvas');
      const qctx=qrcanvas.getContext('2d');
      const scale=Math.max(2,Math.floor(240/mod));
      qrcanvas.width=mod*scale; qrcanvas.height=mod*scale;
      for(let r=0;r<mod;r++) for(let c=0;c<mod;c++){
        qctx.fillStyle=qr.isDark(r,c)?'#000':'#fff';
        qctx.fillRect(c*scale,r*scale,scale,scale);
      }
      const qp=$('#qrPreview'); qp.innerHTML=''; qp.appendChild(qrcanvas);
      showStatus($('#statusEmbed'),'QR Code ditampilkan.','ok');
    }catch(e){
      showStatus($('#statusEmbed'),'Gagal membuat QR: '+(e&&e.message?e.message:String(e)),'err');
    }
  });

  function metric(k,v){ return `<div class="metric"><div class="k">${k}</div><div class="v">${v}</div></div>`; }

  // ---------- verify ----------
  $('#btnVerify').addEventListener('click', async ()=>{
    hideStatus($('#statusVerify'));
    $('#metricsVerify').innerHTML='';
    const qpv0=$('#qrPreviewVerify'); if(qpv0) qpv0.innerHTML='<span class="mono">QR hasil ekstraksi akan muncul di sini</span>';
    if(!verifyImg){ showStatus($('#statusVerify'),'Pilih gambar terlebih dahulu.','err'); return; }
    const pass=$('#passVerify').value;
    if(!pass){ showStatus($('#statusVerify'),'Passphrase wajib diisi.','err'); return; }
    const canvas=document.createElement('canvas');
    canvas.width=verifyImg.naturalWidth; canvas.height=verifyImg.naturalHeight;
    const ctx=canvas.getContext('2d');
    ctx.drawImage(verifyImg,0,0);
    const data=ctx.getImageData(0,0,canvas.width,canvas.height).data;
    const pxCount=canvas.width*canvas.height;
    // read header first 4+1+2+4 = 11 bytes = 88 bits
    function readBits(n){
      const out=[]; let idx=0;
      outer: for(let i=0;i<data.length;i+=4){
        for(let ch=0;ch<3;ch++){
          if(idx>=n) break outer;
          out.push(data[i+ch]&1); idx++;
        }
      }
      return out;
    }
    const hdrBits=readBits(88);
    const hdrBytes=[];
    for(let i=0;i<11;i++){
      let b=0; for(let j=0;j<8;j++) b=(b<<1)|hdrBits[i*8+j];
      hdrBytes.push(b);
    }
    if(hdrBytes[0]!==0x53||hdrBytes[1]!==0x45||hdrBytes[2]!==0x4d||hdrBytes[3]!==0x41){
      showStatus($('#statusVerify'),'Header Semalock tidak ditemukan. Bukan gambar ter-watermark.','err'); return;
    }
    const version=hdrBytes[4];
    const mod=(hdrBytes[5]<<8)|hdrBytes[6];
    const bitLen=(hdrBytes[7]<<24)|(hdrBytes[8]<<16)|(hdrBytes[9]<<8)|hdrBytes[10];
    const expectedBits = mod*mod;
    if(version!==1||mod<21||mod>177||bitLen<=0||bitLen>pxCount*3||bitLen!==expectedBits){
      showStatus($('#statusVerify'),'Data watermark rusak atau tidak valid.','err'); return;
    }
    const totalBits=88+bitLen;
    const allBits=readBits(totalBits);
    const qrBits=allBits.slice(88);
    // reconstruct QR module matrix
    const matrix=[];
    for(let r=0;r<mod;r++){ matrix.push([]); for(let c=0;c<mod;c++) matrix[r].push(qrBits[r*mod+c]); }
    // decode with jsQR (draw with quiet zone for robustness)
    const qrCanvas=document.createElement('canvas');
    const qctx=qrCanvas.getContext('2d');
    const scale=4;
    qrCanvas.width=mod*scale; qrCanvas.height=mod*scale;
    const quiet=4;
    const w=mod+quiet*2;
    const imgData=qctx.createImageData(w,w);
    for(let i=0;i<imgData.data.length;i+=4){ imgData.data[i]=255; imgData.data[i+1]=255; imgData.data[i+2]=255; imgData.data[i+3]=255; }
    for(let r=0;r<mod;r++) for(let c=0;c<mod;c++){
      const v=matrix[r][c]?0:255;
      const i=((r+quiet)*w+(c+quiet))*4;
      imgData.data[i]=v; imgData.data[i+1]=v; imgData.data[i+2]=v; imgData.data[i+3]=255;
    }
    const code=jsQR(imgData.data, w, w);
    if(!code){ showStatus($('#statusVerify'),'QR Code tidak dapat dibaca (data rusak).','err'); return; }
    let env;
    try{ env=unb64u(code.data); }catch(e){ showStatus($('#statusVerify'),'Payload QR tidak valid.','err'); return; }
    // parse envelope
    const dv=new DataView(env.buffer);
    let o=0;
    if(env[0]!==0x53||env[1]!==0x45||env[2]!==0x4d||env[3]!==0x41){ showStatus($('#statusVerify'),'Envelope tidak valid.','err'); return; }
    o=4;
    const ver=env[o++];
    if(ver!==1){ showStatus($('#statusVerify'),'Versi envelope tidak didukung.','err'); return; }
    const iters=dv.getUint32(o,true); o+=4;
    const saltLen=env[o++]; const salt=env.slice(o,o+saltLen); o+=saltLen;
    const ivLen=env[o++]; const iv=env.slice(o,o+ivLen); o+=ivLen;
    const ctLen=dv.getUint32(o,true); o+=4;
    const ct=env.slice(o,o+ctLen); o+=ctLen;
    try{
      const key=await deriveKey(pass,salt,iters);
      const pt=await crypto.subtle.decrypt({name:'AES-GCM',iv}, key, ct);
      const obj=JSON.parse(td.decode(pt));
      // tampilkan QR terekstrak hanya jika verifikasi berhasil
      const qpv=$('#qrPreviewVerify');
      if(qpv){
        const qc=document.createElement('canvas');
        const qcx=qc.getContext('2d');
        const qscale=Math.max(2,Math.floor(240/mod));
        qc.width=mod*qscale; qc.height=mod*qscale;
        for(let r=0;r<mod;r++) for(let c=0;c<mod;c++){
          qcx.fillStyle=matrix[r][c]?'#000':'#fff';
          qcx.fillRect(c*qscale,r*qscale,qscale,qscale);
        }
        qpv.innerHTML=''; qpv.appendChild(qc);
      }
      let html='';
      html+=metric('Nama pencipta',obj.creator||'-');
      html+=metric('Judul karya',obj.title||'-');
      html+=metric('Tahun',obj.year||'-');
      html+=metric('Lisensi/ID',obj.license||'-');
      html+=metric('Dibuat',obj.created||'-');
      $('#metricsVerify').innerHTML=html;
      showStatus($('#statusVerify'),'Verifikasi berhasil. Watermark autentik.','ok');
    }catch(e){
      showStatus($('#statusVerify'),'Passphrase salah atau data rusak (GCM gagal).','err');
      $('#metricsVerify').innerHTML='';
      const qpv=$('#qrPreviewVerify');
      if(qpv) qpv.innerHTML='<span class=\"mono\">QR hasil ekstraksi akan muncul di sini</span>';
    }
  });
})();
</script>
</body>
</html>

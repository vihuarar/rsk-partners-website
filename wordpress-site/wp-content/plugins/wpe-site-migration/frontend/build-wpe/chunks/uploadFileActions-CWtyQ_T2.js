import { j as M, k as f, s, S as E, l as k, n as S, o as T, u as p, p as _, q as D, v as z, w as F, R as I, x as O, I as b, y as d, z as L, A as P } from "./indexWPE-DF7KtW-T.js";
const U = (r) => (e, a) => e(s(P, r)), g = (r) => async (e, a) => {
  const l = d("import_gzipped", a()), t = f("file_size", a()), i = {
    chunk: r.chunk,
    current_query: r.current_query,
    import_file: r.import_filename
  };
  i.import_info = JSON.stringify({
    import_gzipped: l
  });
  let o;
  try {
    o = await S("/import-file", i);
  } catch (A) {
    return e(T(A)), !1;
  }
  const n = o.data, { table_sizes: c, table_rows: m, tables: u } = n;
  e(U({ table_sizes: c, table_rows: m, tables: u }));
  const R = Math.ceil(t / n.num_chunks) / 1e3;
  if (e(p(R)), n.chunk >= n.num_chunks)
    return e(L()), e(s(z, "import")), e(_("START"));
  const w = [
    {
      import_filename: r.import_filename,
      item_name: r.item_name,
      chunk: n.chunk,
      current_query: n.current_query
    }
  ];
  return await e(
    _("IMPORT_FILE", [
      {
        fn: g,
        args: w
      }
    ])
  );
}, y = 1e3 * 1024, q = (r) => async (e, a) => {
  e(s(E, "import")), e(s(I));
  let l;
  try {
    l = await S("/prepare-upload", {});
  } catch (n) {
    return e(T(n)), !1;
  }
  var t = r.name;
  const i = window.wpmdb_strings.importing_file_to_db.replace(
    /%s\s?/,
    t
  );
  e(s(O, i)), t.slice(-3) === ".gz" && (t = r.name.slice(0, -3));
  const o = [
    {
      import_filename: l.data.import_file,
      item_name: t,
      chunk: 0,
      current_query: ""
    }
  ];
  return await e(
    _(b, [
      {
        fn: g,
        args: o
      }
    ])
  );
}, v = (r) => async (e, a) => {
  const l = M("remote_site", a());
  r = typeof r > "u" ? 0 : r;
  const t = f("file", a());
  var i = r + y + 1, o = new FileReader();
  r === 0 && (e(s(E, "upload")), e(
    k(
      Math.ceil(f("file_size", a()) / 1e3)
    )
  )), o.onloadend = async (c) => {
    if (c.target.readyState !== FileReader.DONE)
      return;
    const m = {
      action: "wpmdb_upload_file",
      file_data: c.target.result,
      file: t.name,
      file_type: t.type,
      stage: "import",
      import_info: l
    };
    try {
      await S("/upload-file", m);
    } catch (u) {
      return e(T(u)), !1;
    }
    if (i < t.size)
      return e(p(Math.ceil(y / 1e3))), await e(
        _(D, [
          {
            fn: v,
            args: [i]
          }
        ])
      );
    {
      const u = t.size - r;
      return e(p(Math.ceil(u / 1e3))), e(s(z, "upload")), await e(
        _(F, [
          {
            fn: q,
            args: [t]
          }
        ])
      );
    }
  };
  var n = t.slice(r, i);
  o.readAsDataURL(n);
};
export {
  g as importFile,
  U as setImportTableData,
  v as uploadFileActions
};
//# sourceMappingURL=uploadFileActions-CWtyQ_T2.js.map

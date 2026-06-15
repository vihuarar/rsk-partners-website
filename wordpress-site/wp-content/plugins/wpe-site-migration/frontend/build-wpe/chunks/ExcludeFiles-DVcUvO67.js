import { C as t, _ as p, ak as N, G as q, T as E, H as T } from "./indexWPE-DF7KtW-T.js";
const k = "_textarea_ttnec_8", C = "_title_ttnec_20 _text-base_iyx6q_21 _font-medium_iyx6q_5", P = "_description_ttnec_26 _text-base_iyx6q_21 _font-regular_iyx6q_1", n = {
  "excludes-wrap": "_excludes-wrap_ttnec_1",
  textarea: k,
  "text-wrapper": "_text-wrapper_ttnec_14",
  title: C,
  description: P,
  "sr-only": "_sr-only_ttnec_32 _sr-only_e5q2n_4"
}, B = (e) => {
  const d = (i) => {
    e.excludesUpdater(i.target.value, e.type);
  }, _ = `exclude-files-${e.type}`, u = ({ type: i }) => {
    const { current_migration: x, local_site: m, remote_site: h } = q(
      (c) => c.migrations
    ), g = () => {
      const { intent: c } = x, o = c === "pull", r = o ? h : m, {
        themes_path: w,
        plugins_path: y,
        muplugins_path: f,
        content_dir: b,
        root_path: j
      } = r.site_details, s = o ? r.path : r.this_path, a = (l, v) => l === void 0 ? null : l.replace(v, "").replace(/^\/|\/$/g, "");
      switch (i) {
        case "themes":
          return a(w, s) ?? "wp-content/themes";
        case "plugins":
          return a(y, s) ?? "wp-content/plugins";
        case "muplugins":
          return a(f, s) ?? "wp-content/mu-plugins";
        case "media":
          const l = o ? r.wp_upload_dir : r.this_wp_upload_dir;
          return a(l, s) ?? "wp-content/uploads";
        case "others":
          return a(b, s) ?? "wp-content";
        case "root":
          return a(j, s) ?? "/";
        default:
          return "";
      }
    };
    return /* @__PURE__ */ t.jsx("p", { className: n.description, children: E(
      T(
        p(
          'Use <a href="%s" target="_blank" rel="noopener noreferrer">gitignore patterns</a> to exclude files relative to <code>%s</code>',
          "wp-migrate-db"
        ),
        "https://deliciousbrains.com/wp-migrate-db-pro/doc/ignored-files/",
        g()
      )
    ) });
  };
  return /* @__PURE__ */ t.jsxs("div", { className: n["excludes-wrap"], children: [
    /* @__PURE__ */ t.jsxs("div", { className: n["text-wrapper"], children: [
      /* @__PURE__ */ t.jsxs("h4", { className: n.title, id: _, children: [
        p("Excluded Files", "wp-migrate-db"),
        /* @__PURE__ */ t.jsxs("span", { className: n["sr-only"], children: [
          " ",
          e.type
        ] })
      ] }),
      /* @__PURE__ */ t.jsx(u, { type: e.type })
    ] }),
    /* @__PURE__ */ t.jsx(
      N,
      {
        name: `exclude-files-${e.type}`,
        onChange: d,
        value: e.excludes || "",
        labelledBy: _,
        className: n.textarea,
        resize: "none",
        additionalAttributes: { spellCheck: !1 }
      }
    )
  ] });
};
export {
  B as E
};
//# sourceMappingURL=ExcludeFiles-DVcUvO67.js.map

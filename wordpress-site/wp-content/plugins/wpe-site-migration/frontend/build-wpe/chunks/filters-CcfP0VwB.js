import { r as l, a as u, b as i, g as S, i as x, e as M, f as P, h as w } from "./indexWPE-DF7KtW-T.js";
function C() {
  return (o, T) => {
    const c = () => (s, n) => {
      l.unstable_batchedUpdates(() => {
        s(u("addonActions", () => {
        })), s(
          u("postConnectionPanels", () => {
            s(w("multisite_tools"));
          })
        );
      });
    }, d = () => (s, n) => {
      l.unstable_batchedUpdates(() => {
        s(
          i("wpmdbBackupTables", (e, t) => {
            if (t !== "backup_selected")
              return e;
            const { multisite_tools: r, migrations: _ } = n(), a = r.selected_subsite, { current_migration: b, local_site: m, remote_site: f } = _, { intent: p } = b, g = p === "push" ? f.site_details.prefix : m.this_prefix;
            if (a === 0)
              return e;
            const k = n().migrations;
            return S(
              a,
              g,
              k,
              "backup"
            );
          })
        ), s(
          i("addonPanels", (e, t) => (s(x(t)) && ["savefile", "find_replace", "backup_local"].includes(t) && e.push("multisite_tools"), e))
        ), s(
          i("addonPanelsOpen", (e, t) => (["savefile", "find_replace", "backup_local"].includes(t) && e.push("multisite_tools"), e))
        ), s(
          i("intiateMigrationPostData", (e) => {
            const { multisite_tools: t } = n();
            return t.enabled && (e.mst_select_subsite = "1"), t.selected_subsite > 0 && (e.mst_selected_subsite = Number(
              t.selected_subsite
            ), e.new_prefix = t.new_prefix), t.destination_subsite > 0 && (e.mst_destination_subsite = Number(
              t.destination_subsite
            )), e;
          })
        ), s(
          i("wpmdb_standard_replace_values", (e) => {
            const { multisite_tools: t } = n();
            if (!t.enabled)
              return e;
            const r = s(M());
            return e.domain.search = r.search, e.domain.replace = r.replace, e;
          })
        ), s(
          i("wpmdbPreMigrationCheck", (e) => s(P(e)))
        );
      });
    };
    o(c()), o(d());
  };
}
export {
  C as default
};
//# sourceMappingURL=filters-CcfP0VwB.js.map

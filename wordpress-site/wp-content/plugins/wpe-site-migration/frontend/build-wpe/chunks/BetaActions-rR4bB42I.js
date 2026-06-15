import { ax as n } from "./indexWPE-DF7KtW-T.js";
const r = () => (e, t) => {
  n("beta_optin", t()) || !window.wpmdb_data.is_beta_plugins_installed || !window.confirm(window.wpmdb_strings.rollback_beta_to_stable) || (window.location = window.wpmdb_data.rollback_to_stable_url);
};
export {
  r as betaOptionToggle
};
//# sourceMappingURL=BetaActions-rR4bB42I.js.map

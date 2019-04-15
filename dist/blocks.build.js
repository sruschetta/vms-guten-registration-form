!function(e){function t(l){if(r[l])return r[l].exports;var a=r[l]={i:l,l:!1,exports:{}};return e[l].call(a.exports,a,a.exports,t),a.l=!0,a.exports}var r={};t.m=e,t.c=r,t.d=function(e,r,l){t.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:l})},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=2)}([function(e,t){},function(e,t){},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});r(3),r(4),r(5),r(6)},function(e,t,r){"use strict";function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function o(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var i=r(0),p=(r.n(i),r(1)),s=(r.n(p),function(){function e(e,t){for(var r=0;r<t.length;r++){var l=t[r];l.enumerable=l.enumerable||!1,l.configurable=!0,"value"in l&&(l.writable=!0),Object.defineProperty(e,l.key,l)}}return function(t,r,l){return r&&e(t.prototype,r),l&&e(t,l),t}}()),c=wp.blocks.registerBlockType,u=wp.element.Component,d=wp.data.select("core/editor"),h=(d.getCurrentPostId,wp.components.TextControl),m=wp.editor.RichText;c("vms/vms-plugin-registration-form",{title:"VMS - Registration Form",icon:"welcome-write-blog",category:"widgets",edit:function(e){function t(e){a(this,t);var r=n(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return r.handleChange=function(e){return function(t){r.props.setAttributes(l({},e,t))}},r.handleSelectChange=function(e){return function(t){var a=t.target.value;r.props.setAttributes(l({},e,a))}},r.props=e,r}return o(t,e),s(t,[{key:"render",value:function(){var e=this,t=(this.props.className,this.props.attributes.pages),r=this.props.attributes.target_page,l=[{placeholder:"First name placeholder",attr:"firstname_placeholder"},{placeholder:"Last name placeholder",attr:"lastname_placeholder"},{placeholder:"Email placeholder",attr:"email_placeholder"},{placeholder:"Email Confirm placeholder",attr:"email2_placeholder"},{placeholder:"Password placeholder",attr:"password_placeholder"},{placeholder:"Confirm password placeholder",attr:"password2_placeholder"},{placeholder:"Nation placeholder",attr:"nation_placeholder"},{placeholder:"Birthdate placeholder",attr:"birthdate_placeholder"},{placeholder:"Day placeholder",attr:"day_placeholder"},{placeholder:"Month placeholder",attr:"month_placeholder"},{placeholder:"Year placeholder",attr:"year_placeholder"},{placeholder:"Submit button label",attr:"submit_button_label"}],a=[{placeholder:"First name missing error",attr:"first_name_missing_error"},{placeholder:"Last name missing error",attr:"last_name_missing_error"},{placeholder:"Email missing error",attr:"email_missing_error"},{placeholder:"Email invalid format error",attr:"email_invalid_error"},{placeholder:"Email match error",attr:"email_match_error"},{placeholder:"Password missing placeholder",attr:"password_missing_error"},{placeholder:"Password format error",attr:"password_format_error"},{placeholder:"Password match error",attr:"password_match_error"},{placeholder:"Nation missing error",attr:"nation_missing_error"},{placeholder:"Birthdate missing error",attr:"birthdate_missing_error"},{placeholder:"Invalid date error",attr:"invalid_date_error"},{placeholder:"Privacy error",attr:"privacy_error"}];return wp.element.createElement("div",{class:"vms-form"},wp.element.createElement("h3",null,wp.element.createElement("b",null,"VMS- Registration form")),wp.element.createElement("div",null,"Placeholders"),l.map(function(t,r){return wp.element.createElement(h,{placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Privacy text"),wp.element.createElement(m,{onChange:this.handleChange("privacy_text"),value:this.props.attributes.privacy_text}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Error messages"),a.map(function(t,r){return wp.element.createElement(h,{placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Successful creation message"),wp.element.createElement(m,{onChange:this.handleChange("user_creation_successful_message"),value:this.props.attributes.user_creation_successful_message}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Redirect page"),wp.element.createElement("select",{onChange:this.handleSelectChange("target_page")},t.map(function(e,t){var l=e.ID,a=e.post_name;return a=a.charAt(0).toUpperCase()+a.slice(1),r==l?wp.element.createElement("option",{value:l,selected:"selected"},a):wp.element.createElement("option",{value:l},a)})),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Registration email settings"),wp.element.createElement(h,{placeholder:"Registration email subject",onChange:this.handleChange("registration_email_subject"),value:this.props.attributes.registration_email_subject}),wp.element.createElement(m,{placeholder:"Registration email text",onChange:this.handleChange("registration_email_text"),value:this.props.attributes.registration_email_text}))}}]),t}(u),save:function(){return null}})},function(e,t,r){"use strict";function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function o(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var i=r(0),p=(r.n(i),r(1)),s=(r.n(p),function(){function e(e,t){for(var r=0;r<t.length;r++){var l=t[r];l.enumerable=l.enumerable||!1,l.configurable=!0,"value"in l&&(l.writable=!0),Object.defineProperty(e,l.key,l)}}return function(t,r,l){return r&&e(t.prototype,r),l&&e(t,l),t}}()),c=wp.blocks.registerBlockType,u=wp.element.Component,d=wp.data.select("core/editor"),h=(d.getCurrentPostId,wp.components.TextControl),m=wp.editor.RichText;c("vms/vms-plugin-login-form",{title:"VMS - Login Form",icon:"admin-users",category:"widgets",edit:function(e){function t(e){a(this,t);var r=n(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return r.handleChange=function(e){return function(t){r.props.setAttributes(l({},e,t))}},r.handleSelectChange=function(e){return function(t){var a=t.target.value;r.props.setAttributes(l({},e,a))}},r.props=e,r}return o(t,e),s(t,[{key:"render",value:function(){var e=this,t=(this.props.className,this.props.attributes.pages),r=this.props.attributes.target_page,l=[{placeholder:"Email placeholder",attr:"email_placeholder"},{placeholder:"Password placeholder",attr:"password_placeholder"},{placeholder:"Submit button label",attr:"submit_button_label"}],a=[{placeholder:"Email missing error",attr:"email_missing_error"},{placeholder:"Email invalid format error",attr:"email_invalid_error"},{placeholder:"Password missing error",attr:"password_missing_error"}];return wp.element.createElement("div",{class:"vms-form"},wp.element.createElement("h3",null,wp.element.createElement("b",null,"VMS - Login form")),wp.element.createElement("div",null,"Placeholders"),l.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Redirect page"),wp.element.createElement(m,{type:"text",placeholder:"Footer text",onChange:this.handleChange("footer_text"),value:this.props.attributes.footer_text}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Redirect page"),wp.element.createElement("select",{onChange:this.handleSelectChange("target_page")},t.map(function(e,t){var l=e.ID,a=e.post_name;return a=a.charAt(0).toUpperCase()+a.slice(1),r==l?wp.element.createElement("option",{value:l,selected:"selected"},a):wp.element.createElement("option",{value:l},a)})),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Error messages"),a.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Login error messages"),wp.element.createElement(m,{placeholder:"User not found",onChange:this.handleChange("user_not_found_error"),value:this.props.attributes.user_not_found_error}))}}]),t}(u),save:function(){return null}})},function(e,t,r){"use strict";function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function o(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var i=r(0),p=(r.n(i),r(1)),s=(r.n(p),function(){function e(e,t){for(var r=0;r<t.length;r++){var l=t[r];l.enumerable=l.enumerable||!1,l.configurable=!0,"value"in l&&(l.writable=!0),Object.defineProperty(e,l.key,l)}}return function(t,r,l){return r&&e(t.prototype,r),l&&e(t,l),t}}()),c=wp.blocks.registerBlockType,u=wp.element.Component,d=wp.data.select("core/editor"),h=(d.getCurrentPostId,wp.components.TextControl);wp.editor.RichText;c("vms/vms-plugin-user-dashboard",{title:"VMS - User Dashboard",icon:"welcome-write-blog",category:"widgets",edit:function(e){function t(e){a(this,t);var r=n(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return r.handleChange=function(e){return function(t){r.props.setAttributes(l({},e,t))}},r.handleSelectChange=function(e){return function(t){var a=t.target.value;r.props.setAttributes(l({},e,a))}},r.props=e,r}return o(t,e),s(t,[{key:"render",value:function(){var e=this,t=(this.props.className,[{placeholder:"First name placeholder",attr:"firstname_placeholder"},{placeholder:"Last name placeholder",attr:"lastname_placeholder"},{placeholder:"Email placeholder",attr:"email_placeholder"},{placeholder:"Nation placeholder",attr:"nation_placeholder"},{placeholder:"Birthdate placeholder",attr:"birthdate_placeholder"}]),r=[{placeholder:"Old password placeholder",attr:"old_password_placeholder"},{placeholder:"New password placeholder",attr:"new_password_placeholder"},{placeholder:"Confirm password placeholder",attr:"new_password2_placeholder"}],l=[{placeholder:"Save button label",attr:"save_button_label"},{placeholder:"Cancel button label",attr:"cancel_button_label"},{placeholder:"Logout button label",attr:"logout_button_label"}],a=[{placeholder:"First name missing error",attr:"first_name_missing_error"},{placeholder:"Last name missing error",attr:"last_name_missing_error"},{placeholder:"Birthdate missing error",attr:"birthdate_missing_error"},{placeholder:"Invalid date error",attr:"invalid_date_error"},{placeholder:"Nation missing error",attr:"nation_missing_error"},{placeholder:"Password missing error",attr:"password_missing_error"},{placeholder:"Old password invalid error",attr:"password_invalid_error"},{placeholder:"New password format error",attr:"password_format_error"},{placeholder:"New passwords match error",attr:"password_match_error"},{placeholder:"Different passwords error",attr:"password_different_error"}];return wp.element.createElement("div",{class:"vms-form"},wp.element.createElement("h3",null,wp.element.createElement("b",null,"VMS - User dashboard")),wp.element.createElement("div",null,"Dashboard title"),wp.element.createElement(h,{type:"text",onChange:this.handleChange("dashboard_title"),value:this.props.attributes.dashboard_title}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Placeholders"),t.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Change Password Placeholders"),r.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Button labels"),l.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Errors"),a.map(function(t,r){return wp.element.createElement(h,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}))}}]),t}(u),save:function(){return null}})},function(e,t,r){"use strict";function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function o(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var i=r(0),p=(r.n(i),r(1)),s=(r.n(p),function(){function e(e,t){for(var r=0;r<t.length;r++){var l=t[r];l.enumerable=l.enumerable||!1,l.configurable=!0,"value"in l&&(l.writable=!0),Object.defineProperty(e,l.key,l)}}return function(t,r,l){return r&&e(t.prototype,r),l&&e(t,l),t}}()),c=wp.blocks.registerBlockType,u=wp.element.Component,d=wp.data.select("core/editor"),h=(d.getCurrentPostId,wp.components),m=h.TextControl,b=h.CheckboxControl,f=wp.editor.RichText;c("vms/vms-plugin-models-dashboard",{title:"VMS - Models dashboard",icon:"admin-users",category:"widgets",edit:function(e){function t(e){a(this,t);var r=n(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return r.handleChange=function(e){return function(t){r.props.setAttributes(l({},e,t))}},r.handleSelectChange=function(e){return function(t){var a=t.target.value;r.props.setAttributes(l({},e,a))}},r.props=e,r}return o(t,e),s(t,[{key:"render",value:function(){var e=this,t=(this.props.className,this.props.attributes.pages,this.props.attributes.target_page,[{placeholder:"Dashboard title",attr:"dashboard_title"},{placeholder:"Model ID label",attr:"model_id_label"},{placeholder:"Model title label",attr:"model_title_label"},{placeholder:"Model category label",attr:"model_category_label"},{placeholder:"Model category abbreviation label",attr:"model_category_abbreviation_label"},{placeholder:"Model display label",attr:"model_display_label"},{placeholder:"Add model button label",attr:"add_button_label"},{placeholder:"Receipt download label",attr:"receipt_download_button_label"}]),r=[{placeholder:"Save button label",attr:"save_button_label"},{placeholder:"Cancel button label",attr:"cancel_button_label"}];return wp.element.createElement("div",{class:"vms-form"},wp.element.createElement("h3",null,wp.element.createElement("b",null,"VMS - Models dashboard")),wp.element.createElement("div",null,"Model table"),t.map(function(t,r){return wp.element.createElement(m,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Texts"),wp.element.createElement(f,{type:"text",placeholder:"Header text",onChange:this.handleChange("header_text"),value:this.props.attributes.header_text}),wp.element.createElement(f,{type:"text",placeholder:"New receipt download needed",onChange:this.handleChange("receipt_download_text"),value:this.props.attributes.receipt_download_text}),wp.element.createElement(f,{type:"text",placeholder:"No models text",onChange:this.handleChange("no_models_text"),value:this.props.attributes.no_models_text}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Save/edit dialog"),wp.element.createElement(f,{type:"text",placeholder:"Save/edit dialog header text",onChange:this.handleChange("dialog_header_text"),value:this.props.attributes.dialog_header_text}),r.map(function(t,r){return wp.element.createElement(m,{type:"text",placeholder:t.placeholder,onChange:e.handleChange(t.attr),value:e.props.attributes[t.attr]})}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Delete dialog"),wp.element.createElement(f,{type:"text",placeholder:"Delete dialog header text",onChange:this.handleChange("delete_header_text"),value:this.props.attributes.delete_header_text}),wp.element.createElement(m,{type:"text",placeholder:"Delete button label",onChange:this.handleChange("delete_button_label"),value:this.props.attributes.delete_button_label}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Errors"),wp.element.createElement(m,{type:"text",placeholder:"Title missing error",onChange:this.handleChange("title_missing_error"),value:this.props.attributes.title_missing_error}),wp.element.createElement(m,{type:"text",placeholder:"Category missing error",onChange:this.handleChange("category_missing_error"),value:this.props.attributes.category_missing_error}),wp.element.createElement("hr",null),wp.element.createElement("div",null,"Close contest"),wp.element.createElement(b,{heading:"Close",checked:this.props.attributes.subscription_closed,onChange:this.handleChange("subscription_closed")}))}}]),t}(u),save:function(){return null}})}]);
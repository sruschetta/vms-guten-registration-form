/**
 * BLOCK: vms-user-dashboard
 *
 */

//  Import CSS.
import '../style/style.scss';
import '../style/editor.scss';


const { registerBlockType } = wp.blocks;
const { Component } = wp.element;
const { getCurrentPostId } = wp.data.select("core/editor");
const { TextControl } = wp.components;
const RichText = wp.editor.RichText;

registerBlockType( 'vms/vms-plugin-user-dashboard', {

	title: 'VMS - User Dashboard',
	icon: 'welcome-write-blog',
	category: 'widgets',
	edit: class extends Component {

		  constructor(props) {
		      super(...arguments);
		      this.props = props;
		  }

			handleChange = name => value => {
		    this.props.setAttributes({ [name]: value });
		  }

			handleSelectChange = name => event => {
			 var value = event.target.value;
			 this.props.setAttributes({ [name]: value });
		 	}

		 	render() {
				const { className } = this.props;

				var fieldsAttr = [
				 { placeholder: "First name placeholder", attr: "firstname_placeholder" },
				 { placeholder: "Last name placeholder", attr: "lastname_placeholder" },
				 { placeholder: "Email placeholder", attr: "email_placeholder" },
				 { placeholder: "Nation placeholder", attr: "nation_placeholder" },
				 { placeholder: "Birthdate placeholder", attr: "birthdate_placeholder" },
				];

				var passwordAttr = [
					{ placeholder: "Old password placeholder", attr: "old_password_placeholder" },
					{ placeholder: "New password placeholder", attr: "new_password_placeholder" },
					{ placeholder: "Confirm password placeholder", attr: "new_password2_placeholder" },
				];

				var buttonAttr = [
					{ placeholder: "Save button label", attr: "save_button_label" },
					{ placeholder: "Cancel button label", attr: "cancel_button_label" },
					{ placeholder: "Logout button label", attr: "logout_button_label" },
				];

				var errorAttr = [
					{ placeholder: "First name missing error", attr: "first_name_missing_error" },
					{ placeholder: "Last name missing error", attr: "last_name_missing_error" },
					{ placeholder: "Birthdate missing error", attr: "birthdate_missing_error" },
					{ placeholder: "Invalid date error", attr: "invalid_date_error" },
					{ placeholder: "Nation missing error", attr: "nation_missing_error" },
					{ placeholder: "Password missing error", attr: "password_missing_error" },
					{ placeholder: "Old password invalid error", attr: "password_invalid_error" },
					{ placeholder: "New password format error", attr: "password_format_error" },
					{ placeholder: "New passwords match error", attr: "password_match_error" },
					{ placeholder: "Different passwords error", attr: "password_different_error" }
				];

				return (
					<div class="vms-form">
						<h3><b>VMS - User dashboard</b></h3>
						<div>Dashboard title</div>
						<TextControl type="text"
												 onChange={ this.handleChange('dashboard_title') }
												 value={ this.props.attributes['dashboard_title'] } />
						<hr/>
						<div>Placeholders</div>
						{
							fieldsAttr.map( (item, index) => {
								return (
									<TextControl type="text"
												 placeholder={ item.placeholder }
												 onChange={ this.handleChange(item.attr) }
												 value={ this.props.attributes[item.attr] } />
								)
							})
						}
						<hr/>
						<div>Change Password Placeholders</div>
						{
							passwordAttr.map( (item, index) => {
								return (
									<TextControl type="text"
												 placeholder={ item.placeholder }
												 onChange={ this.handleChange(item.attr) }
												 value={ this.props.attributes[item.attr] } />
								)
							})
						}
						<hr/>
						<div>Button labels</div>
						{
							buttonAttr.map( (item, index) => {
								return (
									<TextControl type="text"
												 placeholder={ item.placeholder }
												 onChange={ this.handleChange(item.attr) }
												 value={ this.props.attributes[item.attr] } />
								)
							})
						}
						<hr/>
						<div>Errors</div>
						{
							errorAttr.map( (item, index) => {
								return (
									<TextControl type="text"
												 placeholder={ item.placeholder }
												 onChange={ this.handleChange(item.attr) }
												 value={ this.props.attributes[item.attr] } />
								)
							})
						}
				</div>
			)
		}
	},
	save: function(){
	  return null;
	}
});

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

				console.log(this.props.attributes);


				var fieldsAttr = [
				 { placeholder: "First name placeholder", attr: "firstname_placeholder" },
				 { placeholder: "Last name placeholder", attr: "lastname_placeholder" },
				 { placeholder: "Email placeholder", attr: "email_placeholder" },
				 { placeholder: "Nation placeholder", attr: "nation_placeholder" },
				 { placeholder: "Age placeholder", attr: "age_placeholder" },
				];

				var passwordAttr = [
					{ placeholder: "Old password placeholder", attr: "old_password_placeholder" },
					{ placeholder: "New password placeholder", attr: "new_password_placeholder" },
					{ placeholder: "Confirm password placeholder", attr: "new_password2_placeholder" },
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
						<div>Button labels</div>
						<TextControl type="text"
												 placeholder={ 'Update button label' }
												 onChange={ this.handleChange('update_button_label') }
												 value={ this.props.attributes['update_button_label'] } />
						<TextControl type="text"
 												 placeholder={ 'Password change button label' }
 												 onChange={ this.handleChange('password_change_button_label') }
 												 value={ this.props.attributes['password_change_button_label'] } />
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
					</div>
			);
		}
	},
	save: function(){
	  return null;
	}
});

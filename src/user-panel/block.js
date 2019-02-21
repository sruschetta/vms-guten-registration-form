/**
 * BLOCK: vms-login-form
 *
 */

//  Import CSS.
import '../style/style.scss';
import '../style/editor.scss';


const { userPanelBlockType } = wp.blocks;
const { Component } = wp.element;

registerBlockType( 'vms/vms-plugin-user-panel', {

	title: 'VMS - User Panel',
	icon: 'welcome-write-blog',
	category: 'widgets',
	edit: class extends Component {

	  constructor(props) {
	      super(...arguments);
	      this.props = props;
	  }

	  render() {
	      return (
	        <div>
	        User panel
	        </div>
	      );
	  }
	},
	save: function(){
	  return null;
	}
});

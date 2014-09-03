// how to import plugin and access its params
$plugin = JPluginHelper::getPlugin('system', 'autologinurl');
$params = new JRegistry($plugin->params);
echo $params->get('environment');


// how to add parameters to a plugin (via its xml file)
<config>
    <fields name="params">
      <fieldset name="basic">
        <field name="alt-text"  type="text" default="" label="Alternative Text" description="Besides Hello World, you can specify other text here to print to the screen instead." />
        <field name="environment" type="radio" default="remoto" label="Entorno local" description="Marcar según la instalación sea en local (MAMP) o remoto" >
          <option value="remoto">Remoto</option>
          <option value="local">Local</option>
        </field>
      </fieldset>
    </fields>
  </config>
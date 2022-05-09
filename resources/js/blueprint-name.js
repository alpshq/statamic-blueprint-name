import Fieldtype from './components/blueprint-name-fieldtype';

Statamic.booting(() => {
  Statamic.$components.register('blueprint_name-fieldtype', Fieldtype);
});

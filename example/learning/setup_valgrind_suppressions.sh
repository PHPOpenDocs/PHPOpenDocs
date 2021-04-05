echo  '#!/bin/bash'                                           >> $HOME/bin/valgrind
echo "/usr/bin/valgrind --suppressions=$HOME/default.supp \$@" >> $HOME/bin/valgrind
chmod +x $HOME/bin/valgrind
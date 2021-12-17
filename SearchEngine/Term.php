<?php
/**
 * Created by Amar Gawade.
 * User: Gas10
 * Date: 1/10/17
 * Time: 4:51 PM
 * Version: 1.0.0
 */
// operators
Class Operator{
    const ANDD="and";
    const ORR="or";
    const NOT="not";
    const RANK="rank";
    const EQUAL_TO="=";
    const OPENING_BRACE="(";
    const CLOSING_BRACE=")";
    const LESS_THAN="<";
    const GREATER_THAN=">";
    const LESS_THAN_EQUAL_TO="<=";
    const GREATER_THAN_EQUAL_TO=">=";
    const PRESENT="1";
    const ABSENT="0";
    const WILDCARD="?";
    const COMMA=",";
    const COLON=":";
}
//name
Class Name{
    const CONN="connection";
    const MORPH="morphology";
    const MARKER="markers";
    const EPHY="electrophysiology";
    const FP="firingpattern";
    const FP_PARAMETER="firingpatternparameter";
}
// keyword
Class Keyword{
    const INC="include";
    const EXC="exclude";
    const BOTH="both";
    const NEURON_NAME="name";
    const NTR="neurotransmitter";
    const NTR_IN="inhibitory";
    const NTR_EX="excitatory";

    const CONN_PRESYN="presynaptic";
    const CONN_POSTSYN="postsynaptic";


    const MORP_AXONS="axons";
    const MORP_DENDRITES="dendrites";
    const MORP_SOMA="soma";
    const MK_DIR_NEG_POS = "d-+";
    const MK_DIR_POS_NEG = "d+-";
    const MK_DIR_PN = "d±";
    const MK_DIR_POS="d+";
    const MK_DIR_NEG="d-";
    const MK_INF_POS_NEG = "i+-";
    const MK_INF_NEG_POS = "i-+";
    const MK_INF_PN = "i±";
    const MK_INF_POS="i+";
    const MK_INF_NEG="i-";

    const FP_DIR_POS="d+";
    const FP_DIR_NEG="d-";
}
?>